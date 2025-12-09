@extends('layouts.app')

@section('title', 'Detalji ugovora - EcoFlow')

@php
    use Illuminate\Support\Facades\URL;
@endphp

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalji ugovora</h1>
                <p class="mt-2 text-sm text-gray-600">Broj ugovora: {{ $wasteContract->contract_number }}</p>
            </div>
            <a href="{{ route('waste-contracts.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                ← Nazad
            </a>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Company -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Kompanija</label>
                <p class="text-lg font-medium text-gray-900">{{ $wasteContract->company->name }}</p>
                <p class="text-sm text-gray-600 mt-1">PIB: {{ $wasteContract->company->pib }}</p>
                <p class="text-sm text-gray-600">{{ $wasteContract->company->adresa }}</p>
            </div>

            <!-- Operator -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Operater</label>
                <p class="text-lg font-medium text-gray-900">{{ $wasteContract->operator->name }}</p>
                <p class="text-sm text-gray-600 mt-1">Broj dozvole: {{ $wasteContract->operator->broj_dozvole }}</p>
                <p class="text-sm text-gray-600">{{ $wasteContract->operator->adresa }}</p>
            </div>

            <!-- Period -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Period važenja</label>
                <p class="text-lg font-medium text-gray-900">
                    {{ $wasteContract->date_start->format('d.m.Y') }}
                    @if($wasteContract->date_end)
                        - {{ $wasteContract->date_end->format('d.m.Y') }}
                    @else
                        - <span class="text-gray-400">Neograničeno</span>
                    @endif
                </p>
            </div>

            <!-- Waste Types -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Vrste otpada</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($wasteContract->waste_types as $type)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ $type }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($wasteContract->notes)
            <div class="mb-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Napomene</label>
                <div class="bg-gray-50 rounded-xl p-6">
                    <p class="text-gray-900 whitespace-pre-line">{{ $wasteContract->notes }}</p>
                </div>
            </div>
        @endif

        <!-- PDF Download -->
        <div class="mb-6 p-6 bg-indigo-50 rounded-xl border border-indigo-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">PDF dokument</h3>
            @if($wasteContract->pdf_path)
                <a href="{{ URL::signedRoute('waste-contracts.download', ['wasteContract' => $wasteContract]) }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Preuzmi PDF ugovor
                </a>
            @else
                <p class="text-gray-600">PDF dokument nije generisan.</p>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('waste-contracts.edit', $wasteContract) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Izmeni ugovor
            </a>
        </div>
    </div>
@endsection

