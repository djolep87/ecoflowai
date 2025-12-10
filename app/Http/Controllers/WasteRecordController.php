<?php

namespace App\Http\Controllers;

use App\Events\WasteRecordCreated;
use App\Events\WasteRecordDeleted;
use App\Events\WasteRecordUpdated;
use App\Models\WasteRecord;
use App\Models\Company;
use App\Models\Operator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WasteRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $wasteRecords = WasteRecord::with(['company', 'operator'])
            ->latest('datum_nastanka')
            ->paginate(15);
        
        return view('waste_records.index', compact('wasteRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::orderBy('name')->get();
        $operators = Operator::where('status', 'aktivan')->orderBy('name')->get();
        
        return view('waste_records.create', compact('companies', 'operators'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'operator_id' => ['nullable', 'exists:operators,id'],
            'waste_type' => ['required', 'string', 'max:255'],
            'kolicina' => ['required', 'numeric', 'min:0'],
            'jedinica_mere' => ['required', 'string', 'in:kg,t,l,m3'],
            'opis' => ['nullable', 'string'],
            'datum_nastanka' => ['required', 'date'],
            'datum_predaje' => ['nullable', 'date', 'after_or_equal:datum_nastanka'],
            'status' => ['required', 'string', 'in:nastao,spreman_za_predaju,predat'],
        ]);

        $wasteRecord = WasteRecord::create($validated);

        // Dispatch event for automatic updates
        event(new WasteRecordCreated($wasteRecord));

        return redirect()->route('waste-records.index')
            ->with('success', 'Zapis evidencije otpada je uspešno kreiran. Evidencijoni listovi i godišnji izveštaji su automatski ažurirani.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WasteRecord $wasteRecord): View
    {
        $companies = Company::orderBy('name')->get();
        $operators = Operator::where('status', 'aktivan')->orderBy('name')->get();
        
        return view('waste_records.edit', compact('wasteRecord', 'companies', 'operators'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WasteRecord $wasteRecord): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'operator_id' => ['nullable', 'exists:operators,id'],
            'waste_type' => ['required', 'string', 'max:255'],
            'kolicina' => ['required', 'numeric', 'min:0'],
            'jedinica_mere' => ['required', 'string', 'in:kg,t,l,m3'],
            'opis' => ['nullable', 'string'],
            'datum_nastanka' => ['required', 'date'],
            'datum_predaje' => ['nullable', 'date', 'after_or_equal:datum_nastanka'],
            'status' => ['required', 'string', 'in:nastao,spreman_za_predaju,predat'],
        ]);

        $wasteRecord->update($validated);
        $wasteRecord->refresh();

        // Dispatch event for automatic updates
        event(new WasteRecordUpdated($wasteRecord));

        return redirect()->route('waste-records.index')
            ->with('success', 'Zapis evidencije otpada je uspešno ažuriran. Evidencijoni listovi i godišnji izveštaji su automatski ažurirani.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WasteRecord $wasteRecord): RedirectResponse
    {
        // Store data before deletion for event
        $companyId = $wasteRecord->company_id;
        $year = $wasteRecord->datum_nastanka->year;
        $wasteType = $wasteRecord->waste_type;

        $wasteRecord->delete();

        // Dispatch event for automatic updates
        event(new WasteRecordDeleted($companyId, $year, $wasteType));

        return redirect()->route('waste-records.index')
            ->with('success', 'Zapis evidencije otpada je uspešno obrisan. Evidencijoni listovi i godišnji izveštaji su automatski ažurirani.');
    }

    /**
     * Get waste types for autocomplete (API endpoint).
     */
    public function getWasteTypes(Request $request)
    {
        $companyId = $request->get('company_id');
        
        $query = WasteRecord::select('waste_type', 'jedinica_mere')
            ->distinct();

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $wasteTypes = $query->orderBy('waste_type')
            ->get()
            ->map(function ($record) {
                return [
                    'type' => $record->waste_type,
                    'unit' => $record->jedinica_mere,
                ];
            });

        return response()->json($wasteTypes);
    }
}

