@extends('layouts.app')

@section('title', 'Dodaj lokaciju - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dodaj novu lokaciju</h1>
            <p class="mt-2 text-sm text-gray-600">Popunite formu sa podacima o lokaciji</p>
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
        <form action="{{ route('locations.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company -->
                <div class="md:col-span-2">
                    <label for="company_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kompanija <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="company_id" 
                        id="company_id" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('company_id') border-red-500 @enderror"
                    >
                        <option value="">Izaberite kompaniju</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Naziv -->
                <div>
                    <label for="naziv" class="block text-sm font-semibold text-gray-700 mb-2">
                        Naziv lokacije <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="naziv" 
                        id="naziv" 
                        value="{{ old('naziv') }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('naziv') border-red-500 @enderror"
                        placeholder="Unesite naziv lokacije"
                    >
                    @error('naziv')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tip -->
                <div>
                    <label for="tip" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tip lokacije <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="tip" 
                        id="tip" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('tip') border-red-500 @enderror"
                    >
                        <option value="">Izaberite tip</option>
                        <option value="magacin" {{ old('tip') == 'magacin' ? 'selected' : '' }}>Magacin</option>
                        <option value="prodavnica" {{ old('tip') == 'prodavnica' ? 'selected' : '' }}>Prodavnica</option>
                        <option value="pogon" {{ old('tip') == 'pogon' ? 'selected' : '' }}>Pogon</option>
                        <option value="kancelarija" {{ old('tip') == 'kancelarija' ? 'selected' : '' }}>Kancelarija</option>
                    </select>
                    @error('tip')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Adresa -->
                <div class="md:col-span-2">
                    <label for="adresa" class="block text-sm font-semibold text-gray-700 mb-2">
                        Adresa <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="adresa" 
                        id="adresa" 
                        value="{{ old('adresa') }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('adresa') border-red-500 @enderror"
                        placeholder="Unesite adresu"
                    >
                    @error('adresa')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kontakt osoba -->
                <div>
                    <label for="kontakt_osoba" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kontakt osoba
                    </label>
                    <input 
                        type="text" 
                        name="kontakt_osoba" 
                        id="kontakt_osoba" 
                        value="{{ old('kontakt_osoba') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('kontakt_osoba') border-red-500 @enderror"
                        placeholder="Unesite ime kontakt osobe"
                    >
                    @error('kontakt_osoba')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telefon -->
                <div>
                    <label for="telefon" class="block text-sm font-semibold text-gray-700 mb-2">
                        Telefon
                    </label>
                    <input 
                        type="text" 
                        name="telefon" 
                        id="telefon" 
                        value="{{ old('telefon') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('telefon') border-red-500 @enderror"
                        placeholder="Unesite telefon"
                    >
                    @error('telefon')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 @error('status') border-red-500 @enderror"
                    >
                        <option value="aktivna" {{ old('status', 'aktivna') == 'aktivna' ? 'selected' : '' }}>Aktivna</option>
                        <option value="neaktivna" {{ old('status') == 'neaktivna' ? 'selected' : '' }}>Neaktivna</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('locations.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj
                </button>
            </div>
        </form>
    </div>
@endsection

