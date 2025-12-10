@extends('layouts.app')

@section('title', 'Dashboard - EcoFlow')

@section('content')
    @php
        $companiesCount = \App\Models\Company::count();
        $locationsCount = \App\Models\Location::count();
        $wastesCount = \App\Models\Waste::count();
        $totalWasteAmount = \App\Models\Waste::sum('kolicina');
        $prijavljenCount = \App\Models\Waste::where('status', 'Prijavljen')->count();
        $uObradiCount = \App\Models\Waste::where('status', 'U obradi')->count();
        $preuzetCount = \App\Models\Waste::where('status', 'Preuzet')->count();
        
        // Waste Records Statistics
        $wasteRecordsCount = \App\Models\WasteRecord::count();
        $wasteRecordsTotal = \App\Models\WasteRecord::sum('kolicina');
        $wasteRecordsByType = \App\Models\WasteRecord::selectRaw('waste_type, SUM(kolicina) as total')
            ->groupBy('waste_type')
            ->orderByDesc('total')
            ->get();
        
        // Evidence Sheets Statistics
        $evidenceSheetsCount = \App\Models\WasteEvidenceSheet::count();
        $evidenceSheetsByYear = \App\Models\WasteEvidenceSheet::selectRaw('godina, SUM(ukupna_kolicina) as total')
            ->groupBy('godina')
            ->orderBy('godina')
            ->get();
        
        // Annual Reports Statistics
        $annualReportsCount = \App\Models\AnnualReport::count();
        $annualReportsByYear = \App\Models\AnnualReport::selectRaw('godina, SUM(ukupno_kolicina) as total')
            ->groupBy('godina')
            ->orderBy('godina')
            ->get();
        $recentReports = \App\Models\AnnualReport::with('company')
            ->latest('created_at')
            ->limit(5)
            ->get();
    @endphp

    <!-- Hero Section -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl shadow-xl p-8 text-white">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-2">
                Dobrodošli, {{ Auth::user()->name }}!
            </h1>
            <p class="text-emerald-50 text-lg">
                Ovo je tvoj centralni panel za upravljanje otpadom.
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Companies Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Kompanije</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $companiesCount }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('companies.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Pogledaj sve →
                </a>
            </div>
        </div>

        <!-- Locations Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Lokacije</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $locationsCount }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('locations.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                    Pogledaj sve →
                </a>
            </div>
        </div>

        <!-- Prijavljeni otpad Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Prijavljeni otpad</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $prijavljenCount }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('wastes.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    Pogledaj sve →
                </a>
            </div>
        </div>

        <!-- Total Waste Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Ukupna količina</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalWasteAmount, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">kg</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('wastes.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                    Detalji →
                </a>
            </div>
        </div>
    </div>

    <!-- Waste Records Statistics -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Evidencija otpada</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Total Records Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Ukupno zapisa</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $wasteRecordsCount }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('waste-records.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Pogledaj sve →
                    </a>
                </div>
            </div>

            <!-- Total Waste Records Amount Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Ukupna količina otpada</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($wasteRecordsTotal, 2, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">različite jedinice mere</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('waste-records.index') }}" class="text-sm text-teal-600 hover:text-teal-700 font-medium">
                        Detalji →
                    </a>
                </div>
            </div>
        </div>

        <!-- Waste Records by Type Chart -->
        @if($wasteRecordsByType->count() > 0)
            <div class="mt-6 bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Količina otpada po vrstama</h3>
                <div class="space-y-4">
                    @foreach($wasteRecordsByType as $item)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $item->waste_type }}</span>
                                <span class="text-sm font-semibold text-gray-900">{{ number_format($item->total, 2, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div 
                                    class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2.5 rounded-full transition-all duration-500"
                                    style="width: {{ $wasteRecordsTotal > 0 ? ($item->total / $wasteRecordsTotal * 100) : 0 }}%"
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Pickup Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Čeka preuzimanje Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Čeka preuzimanje</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $prijavljenCount }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('pickups.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Preuzmi →
                </a>
            </div>
        </div>

        <!-- U obradi Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">U obradi</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $uObradiCount }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('pickups.index') }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                    Pregledaj →
                </a>
            </div>
        </div>

        <!-- Preuzet otpad Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Preuzet otpad</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $preuzetCount }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('wastes.index') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                    Detalji →
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Brze akcije</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <a href="{{ route('companies.create') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Dodaj kompaniju</h3>
                        <p class="text-sm text-gray-600">Nova kompanija</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('locations.create') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Dodaj lokaciju</h3>
                        <p class="text-sm text-gray-600">Nova lokacija</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('wastes.create') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Prijavi otpad</h3>
                        <p class="text-sm text-gray-600">Novi zapis</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('reports.index') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Izveštaji</h3>
                        <p class="text-sm text-gray-600">PDF dokumentacija</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('waste-records.create') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Evidencija otpada</h3>
                        <p class="text-sm text-gray-600">Novi zapis</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('waste-evidence-sheets.create') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Evidencioni list</h3>
                        <p class="text-sm text-gray-600">Novi EL</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('annual-reports.create') }}" class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Godišnji izveštaj</h3>
                        <p class="text-sm text-gray-600">Generiši</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Evidence Sheets Statistics -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Evidencioni listovi otpada (EL)</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Total Evidence Sheets Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Ukupno otvorenih EL</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $evidenceSheetsCount }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('waste-evidence-sheets.index') }}" class="text-sm text-cyan-600 hover:text-cyan-700 font-medium">
                        Pogledaj sve →
                    </a>
                </div>
            </div>

            <!-- Chart by Year -->
            @if($evidenceSheetsByYear->count() > 0)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Količina otpada po godinama</h3>
                    <div class="space-y-3">
                        @foreach($evidenceSheetsByYear as $item)
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">{{ $item->godina }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ number_format($item->total, 2, ',', '.') }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $maxTotal = $evidenceSheetsByYear->max('total');
                                        $percentage = $maxTotal > 0 ? ($item->total / $maxTotal * 100) : 0;
                                    @endphp
                                    <div 
                                        class="bg-gradient-to-r from-cyan-500 to-cyan-600 h-2.5 rounded-full transition-all duration-500"
                                        style="width: {{ $percentage }}%"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Nema podataka</h3>
                        <p class="mt-1 text-sm text-gray-500">Dodajte evidencijone listove da biste videli statistike.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Annual Reports Statistics -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Godišnji izveštaji o otpadu</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Chart by Year -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafikon otpada po godinama</h3>
                @if($annualReportsByYear->count() > 0)
                    <div class="space-y-3">
                        @foreach($annualReportsByYear as $item)
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">{{ $item->godina }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ number_format($item->total, 2, ',', '.') }} kg</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    @php
                                        $maxTotal = $annualReportsByYear->max('total');
                                        $percentage = $maxTotal > 0 ? ($item->total / $maxTotal * 100) : 0;
                                    @endphp
                                    <div 
                                        class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2.5 rounded-full transition-all duration-500"
                                        style="width: {{ $percentage }}%"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Nema podataka</h3>
                        <p class="mt-1 text-sm text-gray-500">Generišite godišnje izveštaje da biste videli statistike.</p>
                    </div>
                @endif
            </div>

            <!-- Recent Reports List -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Poslednji izveštaji</h3>
                    <a href="{{ route('annual-reports.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                        Svi izveštaji →
                    </a>
                </div>
                @if($recentReports->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($recentReports as $report)
                            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $report->company->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Godina: {{ $report->godina }} | {{ number_format($report->ukupno_kolicina, 2, ',', '.') }} kg</p>
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <a href="{{ route('annual-reports.show', $report) }}" class="text-emerald-600 hover:text-emerald-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('annual-reports.pdf', $report->id) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Nema izveštaja</h3>
                        <p class="mt-1 text-sm text-gray-500">Generišite prvi godišnji izveštaj.</p>
                        <div class="mt-6">
                            <a href="{{ route('annual-reports.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors duration-200">
                                Generiši izveštaj
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bulk Actions Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Automatske akcije</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Bulk Generate Evidence Sheets -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Masovno generisanje evidencijskih listova</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Automatski generiši evidencijone listove za sve firme i sve vrste otpada za izabranu godinu.
                </p>
                <form action="{{ route('waste-evidence-sheets.bulk-generate') }}" method="POST" onsubmit="return confirm('Da li ste sigurni da želite da generišete evidencijone listove za sve firme?');">
                    @csrf
                    <div class="flex gap-3">
                        <input 
                            type="number" 
                            name="year" 
                            value="{{ date('Y') }}" 
                            min="2000"
                            max="2100"
                            required
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            placeholder="Godina"
                        >
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-cyan-600 to-cyan-700 text-white rounded-lg font-semibold hover:from-cyan-700 hover:to-cyan-800 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Generiši sve
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bulk Generate Annual Reports -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Masovno generisanje godišnjih izveštaja</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Automatski generiši godišnje izveštaje za sve firme koje imaju podatke u evidenciji otpada.
                </p>
                <form action="{{ route('annual-reports.bulk-generate') }}" method="POST" onsubmit="return confirm('Da li ste sigurni da želite da generišete godišnje izveštaje za sve firme?');">
                    @csrf
                    <div class="flex gap-3">
                        <input 
                            type="number" 
                            name="year" 
                            value="{{ date('Y') }}" 
                            min="2000"
                            max="2100"
                            required
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Godina"
                        >
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Generiši sve
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-2xl font-bold text-gray-900">Nedavne aktivnosti</h2>
        </div>
        <div class="p-6">
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nema aktivnosti</h3>
                <p class="mt-1 text-sm text-gray-500">Aktivnosti će se prikazivati ovde kada počnete sa radom.</p>
            </div>
        </div>
    </div>
@endsection
