<?php

namespace App\Http\Controllers;

use App\Models\WasteEvidenceSheet;
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
}

