<?php

namespace App\Http\Controllers;

use App\Models\WasteEvidenceSheet;
use App\Models\WasteRecord;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WasteEvidenceSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $evidenceSheets = WasteEvidenceSheet::with('company')
            ->latest('godina')
            ->latest('created_at')
            ->paginate(15);
        
        return view('waste_evidence_sheets.index', compact('evidenceSheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::orderBy('name')->get();
        
        return view('waste_evidence_sheets.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'waste_type' => ['required', 'string', 'max:255'],
            'godina' => ['required', 'integer', 'min:2000', 'max:2100'],
            'ukupna_kolicina' => ['required', 'numeric', 'min:0'],
            'jedinica_mere' => ['required', 'string', 'in:kg,t,l,m3'],
            'opis' => ['nullable', 'string'],
        ]);

        WasteEvidenceSheet::create($validated);

        return redirect()->route('waste-evidence-sheets.index')
            ->with('success', 'Evidencioni list je uspešno kreiran.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WasteEvidenceSheet $wasteEvidenceSheet): View
    {
        $companies = Company::orderBy('name')->get();
        
        return view('waste_evidence_sheets.edit', compact('wasteEvidenceSheet', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WasteEvidenceSheet $wasteEvidenceSheet): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'waste_type' => ['required', 'string', 'max:255'],
            'godina' => ['required', 'integer', 'min:2000', 'max:2100'],
            'ukupna_kolicina' => ['required', 'numeric', 'min:0'],
            'jedinica_mere' => ['required', 'string', 'in:kg,t,l,m3'],
            'opis' => ['nullable', 'string'],
        ]);

        $wasteEvidenceSheet->update($validated);

        return redirect()->route('waste-evidence-sheets.index')
            ->with('success', 'Evidencioni list je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WasteEvidenceSheet $wasteEvidenceSheet): RedirectResponse
    {
        $wasteEvidenceSheet->delete();

        return redirect()->route('waste-evidence-sheets.index')
            ->with('success', 'Evidencioni list je uspešno obrisan.');
    }

    /**
     * Generate PDF for the evidence sheet.
     */
    public function generatePdf($id)
    {
        $evidenceSheet = WasteEvidenceSheet::with('company')->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.evidence_sheet', compact('evidenceSheet'));
        
        $filename = 'EL_' . $evidenceSheet->company->name . '_' . $evidenceSheet->godina . '_' . $evidenceSheet->id . '.pdf';
        $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename); // Sanitize filename
        
        return $pdf->download($filename);
    }

    /**
     * Automatically generate evidence sheets from waste records.
     */
    public function generateFromRecords(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'godina' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        // Get all waste records for the company in the specified year
        $wasteRecords = WasteRecord::where('company_id', $validated['company_id'])
            ->whereYear('datum_nastanka', $validated['godina'])
            ->get();

        if ($wasteRecords->isEmpty()) {
            return redirect()->route('waste-evidence-sheets.create')
                ->withErrors(['godina' => 'Nema podataka o otpadu za izabranu firmu i godinu u evidenciji otpada (waste_records).'])
                ->withInput();
        }

        // Group by waste type
        $wasteByType = $wasteRecords->groupBy('waste_type');

        $created = 0;
        $skipped = 0;

        foreach ($wasteByType as $wasteType => $records) {
            // Check if already exists
            $exists = WasteEvidenceSheet::where('company_id', $validated['company_id'])
                ->where('godina', $validated['godina'])
                ->where('waste_type', $wasteType)
                ->exists();

            if (!$exists) {
                WasteEvidenceSheet::create([
                    'company_id' => $validated['company_id'],
                    'waste_type' => $wasteType,
                    'godina' => $validated['godina'],
                    'ukupna_kolicina' => $records->sum('kolicina'),
                    'jedinica_mere' => $records->first()->jedinica_mere ?? 'kg',
                    'opis' => 'Automatski generisano iz evidencije otpada (waste_records)',
                ]);
                $created++;
            } else {
                $skipped++;
            }
        }

        $message = "Uspešno generisano {$created} evidencionih listova iz evidencije otpada.";
        if ($skipped > 0) {
            $message .= " Preskočeno {$skipped} već postojećih.";
        }

        return redirect()->route('waste-evidence-sheets.index')
            ->with('success', $message);
    }

    /**
     * Get waste types for a company and year (API endpoint for AJAX).
     */
    public function getWasteTypes(Request $request)
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $wasteRecords = WasteRecord::where('company_id', $validated['company_id'])
            ->whereYear('datum_nastanka', $validated['year'])
            ->get();

        $wasteTypes = $wasteRecords->groupBy('waste_type')->map(function ($records, $type) {
            return [
                'type' => $type,
                'total' => $records->sum('kolicina'),
                'unit' => $records->first()->jedinica_mere ?? 'kg',
                'count' => $records->count(),
            ];
        })->values();

        return response()->json($wasteTypes);
    }

    /**
     * Bulk generate evidence sheets for all companies and years.
     */
    public function bulkGenerate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'company_ids' => ['nullable', 'array'],
            'company_ids.*' => ['exists:companies,id'],
        ]);

        $year = $validated['year'];
        $companyIds = $validated['company_ids'] ?? Company::pluck('id')->toArray();

        $created = 0;
        $skipped = 0;

        foreach ($companyIds as $companyId) {
            $wasteRecords = WasteRecord::where('company_id', $companyId)
                ->whereYear('datum_nastanka', $year)
                ->get();

            if ($wasteRecords->isEmpty()) {
                continue;
            }

            $wasteByType = $wasteRecords->groupBy('waste_type');

            foreach ($wasteByType as $wasteType => $records) {
                $exists = WasteEvidenceSheet::where('company_id', $companyId)
                    ->where('godina', $year)
                    ->where('waste_type', $wasteType)
                    ->exists();

                if (!$exists) {
                    WasteEvidenceSheet::create([
                        'company_id' => $companyId,
                        'waste_type' => $wasteType,
                        'godina' => $year,
                        'ukupna_kolicina' => $records->sum('kolicina'),
                        'jedinica_mere' => $records->first()->jedinica_mere ?? 'kg',
                        'opis' => 'Automatski generisano iz evidencije otpada',
                    ]);
                    $created++;
                } else {
                    $skipped++;
                }
            }
        }

        $message = "Uspešno generisano {$created} evidencionih listova za godinu {$year}.";
        if ($skipped > 0) {
            $message .= " Preskočeno {$skipped} već postojećih.";
        }

        return redirect()->route('waste-evidence-sheets.index')
            ->with('success', $message);
    }
}

