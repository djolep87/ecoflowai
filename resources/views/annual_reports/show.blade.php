@extends('layouts.app')

@section('title', 'Pregled godišnjeg izveštaja - EcoFlow')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Godišnji izveštaj o otpadu</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        {{ $annualReport->company->name }} - {{ $annualReport->godina }}
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('annual-reports.pdf', $annualReport->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Generiši PDF
                    </a>
                    <a href="{{ route('annual-reports.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                        Nazad
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Ukupna količina</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($annualReport->ukupno_kolicina, 2, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">kg</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Broj vrsta otpada</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $annualReport->broj_vrsta_otpada }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Godina</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $annualReport->godina }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Info -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Podaci o firmi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Naziv firme</p>
                    <p class="text-base font-semibold text-gray-900">{{ $annualReport->company->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">PIB</p>
                    <p class="text-base font-semibold text-gray-900">{{ $annualReport->company->pib }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-600">Adresa</p>
                    <p class="text-base font-semibold text-gray-900">{{ $annualReport->company->adresa }}</p>
                </div>
            </div>
        </div>

        <!-- Waste by Type Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-xl font-bold text-gray-900">Detaljan pregled po vrstama otpada</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Vrsta otpada
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Broj zapisa
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Ukupna količina
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($wasteByType as $index => $waste)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ $index + 1 }}.
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $waste['type'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-700">{{ $waste['count'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ number_format($waste['total'], 2, ',', '.') }} {{ $waste['unit'] }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-gray-50 font-bold">
                            <td colspan="3" class="px-6 py-4 text-right text-sm text-gray-900">
                                UKUPNO:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                {{ number_format($annualReport->ukupno_kolicina, 2, ',', '.') }} kg
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Notes -->
        @if($annualReport->napomena)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Napomena</h2>
            <p class="text-gray-700">{{ $annualReport->napomena }}</p>
        </div>
        @endif
    </div>
@endsection

