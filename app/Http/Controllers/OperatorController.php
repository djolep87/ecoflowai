<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $operators = Operator::latest()->paginate(15);
        
        return view('operators.index', compact('operators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('operators.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'broj_dozvole' => ['required', 'string', 'max:255'],
            'kategorija_dozvole' => ['required', 'string', 'max:255'],
            'adresa' => ['required', 'string', 'max:255'],
            'kontakt_osoba' => ['nullable', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'string', 'in:aktivan,neaktivan'],
        ]);

        Operator::create($validated);

        return redirect()->route('operators.index')
            ->with('success', 'Operater je uspešno dodat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operator $operator): View
    {
        return view('operators.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Operator $operator): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'broj_dozvole' => ['required', 'string', 'max:255'],
            'kategorija_dozvole' => ['required', 'string', 'max:255'],
            'adresa' => ['required', 'string', 'max:255'],
            'kontakt_osoba' => ['nullable', 'string', 'max:255'],
            'telefon' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'status' => ['required', 'string', 'in:aktivan,neaktivan'],
        ]);

        $operator->update($validated);

        return redirect()->route('operators.index')
            ->with('success', 'Operater je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operator $operator): RedirectResponse
    {
        $operator->delete();

        return redirect()->route('operators.index')
            ->with('success', 'Operater je uspešno obrisan.');
    }
}

