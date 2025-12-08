@extends('layouts.app')

@section('title', 'Izmeni operatera - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Izmeni operatera</h1>
            <p class="mt-2 text-sm text-gray-600">Ažurirajte podatke o operateru</p>
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
        <form action="{{ route('operators.update', $operator) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Naziv operatera <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $operator->name) }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('name') border-red-500 @enderror"
                        placeholder="Naziv operatera"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Broj dozvole -->
                <div>
                    <label for="broj_dozvole" class="block text-sm font-semibold text-gray-700 mb-2">
                        Broj dozvole <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="broj_dozvole" 
                        id="broj_dozvole" 
                        value="{{ old('broj_dozvole', $operator->broj_dozvole) }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('broj_dozvole') border-red-500 @enderror"
                        placeholder="Broj dozvole"
                    >
                    @error('broj_dozvole')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategorija dozvole -->
                <div>
                    <label for="kategorija_dozvole" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategorija dozvole <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="kategorija_dozvole" 
                        id="kategorija_dozvole" 
                        value="{{ old('kategorija_dozvole', $operator->kategorija_dozvole) }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('kategorija_dozvole') border-red-500 @enderror"
                        placeholder="Kategorija dozvole"
                    >
                    @error('kategorija_dozvole')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Adresa -->
                <div>
                    <label for="adresa" class="block text-sm font-semibold text-gray-700 mb-2">
                        Adresa <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="adresa" 
                        id="adresa" 
                        value="{{ old('adresa', $operator->adresa) }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('adresa') border-red-500 @enderror"
                        placeholder="Adresa"
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
                        value="{{ old('kontakt_osoba', $operator->kontakt_osoba) }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('kontakt_osoba') border-red-500 @enderror"
                        placeholder="Kontakt osoba"
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
                        value="{{ old('telefon', $operator->telefon) }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('telefon') border-red-500 @enderror"
                        placeholder="Telefon"
                    >
                    @error('telefon')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email', $operator->email) }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                        placeholder="email@example.com"
                    >
                    @error('email')
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
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 @error('status') border-red-500 @enderror"
                    >
                        <option value="aktivan" {{ old('status', $operator->status) == 'aktivan' ? 'selected' : '' }}>Aktivan</option>
                        <option value="neaktivan" {{ old('status', $operator->status) == 'neaktivan' ? 'selected' : '' }}>Neaktivan</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('operators.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-xl font-semibold hover:from-teal-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj izmene
                </button>
            </div>
        </form>
    </div>
@endsection

