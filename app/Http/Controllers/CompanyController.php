<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $companies = Company::latest()->paginate(15);
        
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'pib' => ['required', 'string', 'max:255', 'unique:companies,pib'],
            'maticni_broj' => ['nullable', 'string', 'max:255'],
            'adresa' => ['required', 'string', 'max:255'],
            'kontakt_osoba' => ['nullable', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        Company::create($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Kompanija je uspešno kreirana.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company): View
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'pib' => ['required', 'string', 'max:255', 'unique:companies,pib,' . $company->id],
            'maticni_broj' => ['nullable', 'string', 'max:255'],
            'adresa' => ['required', 'string', 'max:255'],
            'kontakt_osoba' => ['nullable', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $company->update($validated);

        return redirect()->route('companies.index')
            ->with('success', 'Kompanija je uspešno ažurirana.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Kompanija je uspešno obrisana.');
    }
}

