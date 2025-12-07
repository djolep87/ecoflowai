<?php

namespace App\Http\Controllers;

use App\Models\Waste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
        return view('pickups.show', compact('waste'));
    }

    /**
     * Update the status of a waste (for operators).
     */
    public function updateStatus(Request $request, Waste $waste): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:U obradi,Preuzet'],
        ]);

        $waste->status = $validated['status'];
        
        if ($validated['status'] === 'Preuzet') {
            $waste->operator_id = Auth::id();
            $waste->datum_preuzimanja = now();
        }
        
        $waste->save();

        $message = $validated['status'] === 'Preuzet' 
            ? 'Otpad je uspešno preuzet.' 
            : 'Status otpada je ažuriran na "U obradi".';

        return redirect()->route('pickups.index')
            ->with('success', $message);
    }
}

