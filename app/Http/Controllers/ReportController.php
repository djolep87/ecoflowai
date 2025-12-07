<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Location;
use App\Models\Waste;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display a listing of wastes with filters.
     */
    public function index(Request $request): View
    {
        $query = Waste::with(['company', 'location', 'operator']);

        // Filter by company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Filter by location
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Filter by tip otpada
        if ($request->filled('tip_otpada')) {
            $query->where('tip_otpada', $request->tip_otpada);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('datum_od')) {
            $query->whereDate('datum_nastanka', '>=', $request->datum_od);
        }
        if ($request->filled('datum_do')) {
            $query->whereDate('datum_nastanka', '<=', $request->datum_do);
        }

        $wastes = $query->latest()->paginate(15);
        $companies = Company::orderBy('name')->get();
        $locations = Location::orderBy('naziv')->get();
        
        $tipovi = ['Papir', 'Plastika', 'Metal', 'Elektronski otpad', 'Staklo', 'Bio otpad', 'Ostalo'];
        $statusi = ['Prijavljen', 'U obradi', 'Preuzet'];

        return view('reports.index', compact('wastes', 'companies', 'locations', 'tipovi', 'statusi'));
    }

    /**
     * Generate and download PDF report for a specific waste.
     */
    public function downloadPdf(Waste $waste)
    {
        $waste->load(['company', 'location', 'operator']);

        $pdf = Pdf::loadView('reports.pdf', compact('waste'));
        
        $filename = 'izvestaj_otpad_' . $waste->id . '_' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}

