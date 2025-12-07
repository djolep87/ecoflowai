@extends('layouts.app')

@section('title', 'Detalji otpada - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalji otpada</h1>
                <p class="mt-2 text-sm text-gray-600">Pregled informacija o otpadu</p>
            </div>
            <a href="{{ route('pickups.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                ← Nazad
            </a>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Company -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Kompanija</label>
                <p class="text-lg font-medium text-gray-900">{{ $waste->company->name }}</p>
            </div>

            <!-- Location -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Lokacija</label>
                <p class="text-lg font-medium text-gray-900">{{ $waste->location->naziv }}</p>
                <p class="text-sm text-gray-600 mt-1">{{ $waste->location->adresa }}</p>
            </div>

            <!-- Tip otpada -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Tip otpada</label>
                <p class="text-lg font-medium text-gray-900">{{ $waste->tip_otpada }}</p>
            </div>

            <!-- Količina -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Količina</label>
                <p class="text-lg font-medium text-gray-900">{{ number_format($waste->kolicina, 2, ',', '.') }} kg</p>
            </div>

            <!-- Datum nastanka -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Datum nastanka</label>
                <p class="text-lg font-medium text-gray-900">{{ $waste->datum_nastanka->format('d.m.Y') }}</p>
            </div>

            <!-- Status -->
            <div class="bg-gray-50 rounded-xl p-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Status</label>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($waste->status === 'Prijavljen') bg-blue-100 text-blue-800
                    @elseif($waste->status === 'U obradi') bg-yellow-100 text-yellow-800
                    @else bg-green-100 text-green-800
                    @endif">
                    {{ $waste->status }}
                </span>
            </div>

            <!-- Operator -->
            @if($waste->operator)
                <div class="bg-gray-50 rounded-xl p-6">
                    <label class="text-sm font-semibold text-gray-600 mb-2 block">Operator</label>
                    <p class="text-lg font-medium text-gray-900">{{ $waste->operator->name }}</p>
                </div>
            @endif

            <!-- Datum preuzimanja -->
            @if($waste->datum_preuzimanja)
                <div class="bg-gray-50 rounded-xl p-6">
                    <label class="text-sm font-semibold text-gray-600 mb-2 block">Datum preuzimanja</label>
                    <p class="text-lg font-medium text-gray-900">{{ $waste->datum_preuzimanja->format('d.m.Y H:i') }}</p>
                </div>
            @endif
        </div>

        <!-- Napomena -->
        @if($waste->napomena)
            <div class="mb-6">
                <label class="text-sm font-semibold text-gray-600 mb-2 block">Napomena</label>
                <div class="bg-gray-50 rounded-xl p-6">
                    <p class="text-gray-900">{{ $waste->napomena }}</p>
                </div>
            </div>
        @endif

        <!-- Actions -->
        @if(in_array($waste->status, ['Prijavljen', 'U obradi']))
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                @if($waste->status === 'Prijavljen')
                    <form action="{{ route('pickups.updateStatus', $waste) }}" method="POST" class="inline-block" onsubmit="return confirm('Da li želite da preuzmete ovaj otpad u obradu?');">
                        @csrf
                        <input type="hidden" name="status" value="U obradi">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white rounded-xl font-semibold hover:bg-yellow-700 transition-colors duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Preuzmi u obradu
                        </button>
                    </form>
                @endif
                <form action="{{ route('pickups.updateStatus', $waste) }}" method="POST" class="inline-block" onsubmit="return confirm('Da li ste sigurni da želite da označite ovaj otpad kao preuzet?');">
                    @csrf
                    <input type="hidden" name="status" value="Preuzet">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Označi kao preuzet
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection

