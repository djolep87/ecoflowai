@extends('layouts.app')

@section('title', 'Kreiraj ugovor - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Kreiraj novi ugovor</h1>
            <p class="mt-2 text-sm text-gray-600">Popunite formu sa podacima o ugovoru</p>
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
        <form action="{{ route('waste-contracts.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company -->
                <div>
                    <label for="company_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kompanija <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="company_id" 
                        id="company_id" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('company_id') border-red-500 @enderror"
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

                <!-- Operator -->
                <div>
                    <label for="operator_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Operater <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="operator_id" 
                        id="operator_id" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('operator_id') border-red-500 @enderror"
                    >
                        <option value="">Izaberite operatera</option>
                        @foreach($operators as $operator)
                            <option value="{{ $operator->id }}" {{ old('operator_id') == $operator->id ? 'selected' : '' }}>
                                {{ $operator->name }} ({{ $operator->broj_dozvole }})
                            </option>
                        @endforeach
                    </select>
                    @error('operator_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Start -->
                <div>
                    <label for="date_start" class="block text-sm font-semibold text-gray-700 mb-2">
                        Datum početka <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="date_start" 
                        id="date_start" 
                        value="{{ old('date_start') }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('date_start') border-red-500 @enderror"
                    >
                    @error('date_start')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date End -->
                <div>
                    <label for="date_end" class="block text-sm font-semibold text-gray-700 mb-2">
                        Datum završetka
                    </label>
                    <input 
                        type="date" 
                        name="date_end" 
                        id="date_end" 
                        value="{{ old('date_end') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('date_end') border-red-500 @enderror"
                    >
                    @error('date_end')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waste Types -->
                <div class="md:col-span-2">
                    <label for="waste_types" class="block text-sm font-semibold text-gray-700 mb-2">
                        Vrste otpada <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($wasteTypes as $type)
                            <label class="flex items-center space-x-2 p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="waste_types[]" 
                                    value="{{ $type }}"
                                    {{ in_array($type, old('waste_types', [])) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                >
                                <span class="text-sm text-gray-700">{{ $type }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('waste_types')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                        Napomene
                    </label>
                    <textarea 
                        name="notes" 
                        id="notes" 
                        rows="4"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 @error('notes') border-red-500 @enderror"
                        placeholder="Dodatne napomene o ugovoru..."
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('waste-contracts.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Kreiraj ugovor
                </button>
            </div>
        </form>
    </div>
@endsection

