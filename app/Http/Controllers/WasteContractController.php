<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Operator;
use App\Models\WasteContract;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WasteContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $contracts = WasteContract::with(['company', 'operator', 'creator'])
            ->latest()
            ->paginate(15);
        
        return view('waste_contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::orderBy('name')->get();
        $operators = Operator::where('status', 'aktivan')->orderBy('name')->get();
        $wasteTypes = ['Papir', 'Plastika', 'Metal', 'Elektronski otpad', 'Staklo', 'Bio otpad', 'Ostalo'];
        
        return view('waste_contracts.create', compact('companies', 'operators', 'wasteTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'operator_id' => ['required', 'exists:operators,id'],
            'date_start' => ['required', 'date'],
            'date_end' => ['nullable', 'date', 'after_or_equal:date_start'],
            'waste_types' => ['required', 'array', 'min:1'],
            'waste_types.*' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();
        
        try {
            // Generate contract number
            $contractNumber = $this->generateContractNumber();
            
            $validated['contract_number'] = $contractNumber;
            $validated['created_by'] = Auth::id();
            
            $contract = WasteContract::create($validated);
            
            // Generate and save PDF
            $pdfPath = $this->generatePdf($contract);
            $contract->update(['pdf_path' => $pdfPath]);
            
            DB::commit();
            
            return redirect()->route('waste-contracts.index')
                ->with('success', 'Ugovor je uspešno kreiran.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Greška pri kreiranju ugovora: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteContract $wasteContract): View
    {
        $wasteContract->load(['company', 'operator', 'creator']);
        
        return view('waste_contracts.show', compact('wasteContract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WasteContract $wasteContract): View
    {
        $companies = Company::orderBy('name')->get();
        $operators = Operator::where('status', 'aktivan')->orderBy('name')->get();
        $wasteTypes = ['Papir', 'Plastika', 'Metal', 'Elektronski otpad', 'Staklo', 'Bio otpad', 'Ostalo'];
        
        return view('waste_contracts.edit', compact('wasteContract', 'companies', 'operators', 'wasteTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WasteContract $wasteContract): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'operator_id' => ['required', 'exists:operators,id'],
            'date_start' => ['required', 'date'],
            'date_end' => ['nullable', 'date', 'after_or_equal:date_start'],
            'waste_types' => ['required', 'array', 'min:1'],
            'waste_types.*' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();
        
        try {
            // Check if key fields changed (need to regenerate PDF)
            $needsRegeneration = 
                $wasteContract->company_id != $validated['company_id'] ||
                $wasteContract->operator_id != $validated['operator_id'] ||
                $wasteContract->date_start != $validated['date_start'] ||
                $wasteContract->date_end != $validated['date_end'] ||
                $wasteContract->waste_types != $validated['waste_types'];
            
            $wasteContract->update($validated);
            
            // Regenerate PDF if needed
            if ($needsRegeneration) {
                // Delete old PDF
                if ($wasteContract->pdf_path && Storage::disk('public')->exists($wasteContract->pdf_path)) {
                    Storage::disk('public')->delete($wasteContract->pdf_path);
                }
                
                // Generate new PDF
                $pdfPath = $this->generatePdf($wasteContract);
                $wasteContract->update(['pdf_path' => $pdfPath]);
            }
            
            DB::commit();
            
            return redirect()->route('waste-contracts.index')
                ->with('success', 'Ugovor je uspešno ažuriran.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Greška pri ažuriranju ugovora: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WasteContract $wasteContract): RedirectResponse
    {
        // Delete PDF file if exists
        if ($wasteContract->pdf_path && Storage::disk('public')->exists($wasteContract->pdf_path)) {
            Storage::disk('public')->delete($wasteContract->pdf_path);
        }
        
        $wasteContract->delete();
        
        return redirect()->route('waste-contracts.index')
            ->with('success', 'Ugovor je uspešno obrisan.');
    }

    /**
     * Download the contract PDF via signed URL.
     */
    public function download(WasteContract $wasteContract)
    {
        if (!$wasteContract->pdf_path || !Storage::disk('public')->exists($wasteContract->pdf_path)) {
            abort(404, 'PDF fajl nije pronađen.');
        }
        
        return Storage::disk('public')->download($wasteContract->pdf_path);
    }

    /**
     * Generate contract number in format UG-{year}-{0001}
     */
    private function generateContractNumber(): string
    {
        $year = now()->year;
        $prefix = "UG-{$year}-";
        
        // Get the last contract number for this year
        $lastContract = WasteContract::where('contract_number', 'like', $prefix . '%')
            ->orderBy('contract_number', 'desc')
            ->first();
        
        if ($lastContract) {
            // Extract the number part and increment
            $lastNumber = (int) substr($lastContract->contract_number, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate PDF for the contract.
     */
    private function generatePdf(WasteContract $contract): string
    {
        // Ensure directory exists
        $directory = storage_path('app/public/waste_contracts');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $contract->load(['company', 'operator', 'creator']);
        
        $pdf = PDF::loadView('waste_contracts.pdf', compact('contract'));
        
        $filename = $contract->contract_number . '.pdf';
        $relativePath = 'waste_contracts/' . $filename;
        $fullPath = storage_path('app/public/' . $relativePath);
        
        $pdf->save($fullPath);
        
        return $relativePath;
    }
}

