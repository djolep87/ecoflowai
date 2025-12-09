<?php

namespace App\Http\Controllers;

use App\Models\AnnualReport;
use App\Models\Company;
use App\Services\AnnualReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnualReportController extends Controller
{
    protected AnnualReportService $reportService;

    public function __construct(AnnualReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $reports = AnnualReport::with('company')
            ->latest('godina')
            ->latest('created_at')
            ->paginate(15);
        
        return view('annual_reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::orderBy('name')->get();
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear + 1);
        
        return view('annual_reports.create', compact('companies', 'years', 'currentYear'));
    }

    /**
     * Generate and store a new annual report.
     */
    public function generate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'godina' => ['required', 'integer', 'min:2000', 'max:2100'],
            'napomena' => ['nullable', 'string'],
        ]);

        $companyId = $validated['company_id'];
        $year = $validated['godina'];

        // Check if report already exists
        $existingReport = AnnualReport::where('company_id', $companyId)
            ->where('godina', $year)
            ->first();

        if ($existingReport) {
            return redirect()->route('annual-reports.create')
                ->withErrors(['godina' => 'Izveštaj za ovu firmu i godinu već postoji.'])
                ->withInput();
        }

        // Generate report data
        $reportData = $this->reportService->generateReportData($companyId, $year);

        // Check if there are any waste records
        if ($reportData['total_records'] === 0) {
            return redirect()->route('annual-reports.create')
                ->withErrors(['godina' => 'Nema podataka o otpadu za izabranu firmu i godinu.'])
                ->withInput();
        }

        // Create the report
        $report = AnnualReport::create([
            'company_id' => $companyId,
            'godina' => $year,
            'ukupno_kolicina' => $reportData['ukupno_kolicina'],
            'broj_vrsta_otpada' => $reportData['broj_vrsta_otpada'],
            'napomena' => $validated['napomena'] ?? null,
        ]);

        return redirect()->route('annual-reports.show', $report)
            ->with('success', 'Godišnji izveštaj je uspešno generisan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnualReport $annualReport): View
    {
        $annualReport->load('company');
        
        // Get detailed waste data by type
        $wasteByType = $this->reportService->getWasteByType(
            $annualReport->company_id,
            $annualReport->godina
        );

        return view('annual_reports.show', compact('annualReport', 'wasteByType'));
    }

    /**
     * Generate PDF for the annual report.
     */
    public function pdf($id)
    {
        $report = AnnualReport::with('company')->findOrFail($id);
        
        // Get detailed waste data by type
        $wasteByType = $this->reportService->getWasteByType(
            $report->company_id,
            $report->godina
        );
        
        $pdf = Pdf::loadView('pdf.annual_report', compact('report', 'wasteByType'));
        
        $filename = 'Godisnji_izvestaj_' . $report->company->name . '_' . $report->godina . '.pdf';
        $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename); // Sanitize filename
        
        return $pdf->download($filename);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnualReport $annualReport): RedirectResponse
    {
        $annualReport->delete();

        return redirect()->route('annual-reports.index')
            ->with('success', 'Godišnji izveštaj je uspešno obrisan.');
    }
}

