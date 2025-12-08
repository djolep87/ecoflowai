@extends('layouts.app')

@section('title', 'Dodaj KPO zapis - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dodaj novi KPO zapis</h1>
            <p class="mt-2 text-sm text-gray-600">Popunite formu sa podacima o KPO zapisu</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Molimo ispravite sledeće greške:
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('kpo.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Waste -->
                <div>
                    <label for="waste_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Otpad <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="waste_id" 
                        id="waste_id" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 @error('waste_id') border-red-500 @enderror"
                    >
                        <option value="">Izaberite otpad</option>
                        @foreach($wastes as $waste)
                            <option value="{{ $waste->id }}" {{ old('waste_id') == $waste->id ? 'selected' : '' }}>
                                {{ $waste->tip_otpada }} - {{ $waste->company->name }} ({{ number_format($waste->kolicina, 2, ',', '.') }} kg)
                            </option>
                        @endforeach
                    </select>
                    @error('waste_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Datum -->
                <div>
                    <label for="datum" class="block text-sm font-semibold text-gray-700 mb-2">
                        Datum <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="datum" 
                        id="datum" 
                        value="{{ old('datum', date('Y-m-d')) }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 @error('datum') border-red-500 @enderror"
                    >
                    @error('datum')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Količina -->
                <div>
                    <label for="kolicina" class="block text-sm font-semibold text-gray-700 mb-2">
                        Količina (kg) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="kolicina" 
                        id="kolicina" 
                        value="{{ old('kolicina') }}" 
                        required
                        step="0.01"
                        min="0.01"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 @error('kolicina') border-red-500 @enderror"
                        placeholder="0.00"
                    >
                    @error('kolicina')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Način postupanja -->
                <div>
                    <label for="nacin_postupanja" class="block text-sm font-semibold text-gray-700 mb-2">
                        Način postupanja <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="nacin_postupanja" 
                        id="nacin_postupanja" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 @error('nacin_postupanja') border-red-500 @enderror"
                    >
                        <option value="">Izaberite način postupanja</option>
                        @foreach($nacini as $nacin)
                            <option value="{{ $nacin }}" {{ old('nacin_postupanja') == $nacin ? 'selected' : '' }}>
                                {{ $nacin }}
                            </option>
                        @endforeach
                    </select>
                    @error('nacin_postupanja')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opis -->
                <div class="md:col-span-2">
                    <label for="opis" class="block text-sm font-semibold text-gray-700 mb-2">
                        Opis
                    </label>
                    <textarea 
                        name="opis" 
                        id="opis" 
                        rows="4"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition-all duration-200 @error('opis') border-red-500 @enderror"
                        placeholder="Dodatne napomene..."
                    >{{ old('opis') }}</textarea>
                    @error('opis')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('kpo.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 text-white rounded-xl font-semibold hover:from-violet-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj
                </button>
            </div>
        </form>
    </div>
@endsection

