<?php

namespace App\Http\Controllers;

use App\Models\KpoEntry;
use App\Models\Operator;
use App\Models\Waste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PickupController extends Controller
{
    /**
     * Display a listing of wastes available for pickup.
     */
    public function index(): View
    {
        $wastes = Waste::with(['company', 'location', 'operator'])
            ->whereIn('status', ['Prijavljen', 'U obradi'])
            ->latest()
            ->paginate(15);
        
        return view('pickups.index', compact('wastes'));
    }

    /**
     * Show the details of a specific waste.
     */
    public function show(Waste $waste): View
    {
        $waste->load(['company', 'location', 'operator']);
        $operators = Operator::where('status', 'aktivan')->orderBy('name')->get();
        
        return view('pickups.show', compact('waste', 'operators'));
    }

    /**
     * Update the status of a waste (for operators).
     */
    public function updateStatus(Request $request, Waste $waste): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:U obradi,Preuzet'],
            'operator_id' => ['required_if:status,Preuzet', 'exists:operators,id'],
            'datum_preuzimanja' => ['nullable', 'date'],
            'napomena' => ['nullable', 'string'],
        ]);

        $waste->status = $validated['status'];
        
        if ($validated['status'] === 'Preuzet') {
            $waste->operator_id = $validated['operator_id'];
            $waste->datum_preuzimanja = $validated['datum_preuzimanja'] ?? now();
            if (isset($validated['napomena'])) {
                $waste->napomena = ($waste->napomena ? $waste->napomena . "\n\n" : '') . 'Napomena pri preuzimanju: ' . $validated['napomena'];
            }
            
            $waste->save();
            
            // Automatski kreiraj KPO zapis
            KpoEntry::create([
                'waste_id' => $waste->id,
                'datum' => now()->toDateString(),
                'kolicina' => $waste->kolicina,
                'nacin_postupanja' => 'Preuzimanje operater',
                'opis' => isset($validated['napomena']) ? 'Napomena pri preuzimanju: ' . $validated['napomena'] : null,
            ]);
        } else {
            $waste->save();
        }

        $message = $validated['status'] === 'Preuzet' 
            ? 'Otpad je uspešno preuzet.' 
            : 'Status otpada je ažuriran na "U obradi".';

        return redirect()->route('pickups.index')
            ->with('success', $message);
    }
}

