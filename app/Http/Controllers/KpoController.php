<?php

namespace App\Http\Controllers;

use App\Models\KpoEntry;
use App\Models\Waste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KpoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kpoEntries = KpoEntry::with(['waste.company', 'waste.location'])
            ->latest('datum')
            ->paginate(15);
        
        return view('kpo.index', compact('kpoEntries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $wastes = Waste::with('company')->orderBy('datum_nastanka', 'desc')->get();
        $nacini = ['Skladištenje', 'Transport', 'Preuzimanje operater'];
        
        return view('kpo.create', compact('wastes', 'nacini'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'waste_id' => ['required', 'exists:wastes,id'],
            'datum' => ['required', 'date'],
            'kolicina' => ['required', 'numeric', 'min:0.01'],
            'nacin_postupanja' => ['required', 'string', 'in:Skladištenje,Transport,Preuzimanje operater'],
            'opis' => ['nullable', 'string'],
        ]);

        KpoEntry::create($validated);

        return redirect()->route('kpo.index')
            ->with('success', 'KPO zapis je uspešno dodat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KpoEntry $kpo): View
    {
        $wastes = Waste::with('company')->orderBy('datum_nastanka', 'desc')->get();
        $nacini = ['Skladištenje', 'Transport', 'Preuzimanje operater'];
        
        return view('kpo.edit', compact('kpo', 'wastes', 'nacini'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KpoEntry $kpo): RedirectResponse
    {
        $validated = $request->validate([
            'waste_id' => ['required', 'exists:wastes,id'],
            'datum' => ['required', 'date'],
            'kolicina' => ['required', 'numeric', 'min:0.01'],
            'nacin_postupanja' => ['required', 'string', 'in:Skladištenje,Transport,Preuzimanje operater'],
            'opis' => ['nullable', 'string'],
        ]);

        $kpo->update($validated);

        return redirect()->route('kpo.index')
            ->with('success', 'KPO zapis je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KpoEntry $kpo): RedirectResponse
    {
        $kpo->delete();

        return redirect()->route('kpo.index')
            ->with('success', 'KPO zapis je uspešno obrisan.');
    }
}

