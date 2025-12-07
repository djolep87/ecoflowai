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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
