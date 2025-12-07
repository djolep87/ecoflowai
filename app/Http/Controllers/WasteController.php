<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Location;
use App\Models\Waste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $wastes = Waste::with(['company', 'location'])->latest()->paginate(15);
        
        return view('wastes.index', compact('wastes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::orderBy('name')->get();
        $locations = Location::orderBy('naziv')->get();
        
        return view('wastes.create', compact('companies', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'tip_otpada' => ['required', 'string', 'max:255'],
            'kolicina' => ['required', 'numeric', 'min:0.01'],
            'datum_nastanka' => ['required', 'date'],
            'napomena' => ['nullable', 'string'],
        ]);

        // Status se automatski postavlja na 'Prijavljen' i može se menjati samo preko Pickup modula
        $validated['status'] = 'Prijavljen';

        Waste::create($validated);

        return redirect()->route('wastes.index')
            ->with('success', 'Otpad je uspešno prijavljen.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waste $waste): View
    {
        $companies = Company::orderBy('name')->get();
        $locations = Location::where('company_id', $waste->company_id)->orderBy('naziv')->get();
        
        return view('wastes.edit', compact('waste', 'companies', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Waste $waste): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'tip_otpada' => ['required', 'string', 'max:255'],
            'kolicina' => ['required', 'numeric', 'min:0.01'],
            'datum_nastanka' => ['required', 'date'],
            'napomena' => ['nullable', 'string'],
        ]);

        // Status se ne može menjati preko Waste CRUD-a, samo preko Pickup modula
        // Zadržavamo postojeći status
        $validated['status'] = $waste->status;

        $waste->update($validated);

        return redirect()->route('wastes.index')
            ->with('success', 'Otpad je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Waste $waste): RedirectResponse
    {
        $waste->delete();

        return redirect()->route('wastes.index')
            ->with('success', 'Otpad je uspešno obrisan.');
    }
}

