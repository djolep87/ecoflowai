<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $locations = Location::with('company')->latest()->paginate(15);
        
        return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $companies = Company::orderBy('name')->get();
        
        return view('locations.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'naziv' => ['required', 'string', 'max:255'],
            'adresa' => ['required', 'string', 'max:255'],
            'tip' => ['required', 'string', 'in:magacin,prodavnica,pogon,kancelarija'],
            'kontakt_osoba' => ['nullable', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        Location::create($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Lokacija je uspešno kreirana.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location): View
    {
        $companies = Company::orderBy('name')->get();
        
        return view('locations.edit', compact('location', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location): RedirectResponse
    {
        $validated = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'naziv' => ['required', 'string', 'max:255'],
            'adresa' => ['required', 'string', 'max:255'],
            'tip' => ['required', 'string', 'in:magacin,prodavnica,pogon,kancelarija'],
            'kontakt_osoba' => ['nullable', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $location->update($validated);

        return redirect()->route('locations.index')
            ->with('success', 'Lokacija je uspešno ažurirana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Lokacija je uspešno obrisana.');
    }
}

