@extends('layouts.app')

@section('title', 'Dodaj evidencijoni list - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dodaj novi evidencijoni list otpada</h1>
            <p class="mt-2 text-sm text-gray-600">Popunite formu sa podacima o evidenciji otpada</p>
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

        <!-- Automatic Generation Section -->
        <div class="mb-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Automatsko generisanje iz evidencije otpada</h3>
                    <p class="text-sm text-blue-800 mb-4">
                        Umesto ručnog unosa, možete automatski generisati evidencijone listove za sve vrste otpada iz podataka evidencije otpada (waste_records) za izabranu firmu i godinu.
                    </p>
                    <form action="{{ route('waste-evidence-sheets.generate-from-records') }}" method="POST" class="bg-white p-4 rounded-lg border border-blue-200">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="auto_company_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Firma <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="company_id" 
                                    id="auto_company_id" 
                                    required
                                    class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                >
                                    <option value="">Izaberite firmu</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="auto_godina" class="block text-sm font-medium text-gray-700 mb-1">
                                    Godina <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    name="godina" 
                                    id="auto_godina" 
                                    value="{{ date('Y') }}" 
                                    min="2000"
                                    max="2100"
                                    required
                                    class="relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="2024"
                                >
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-md hover:shadow-lg text-sm">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Generiši automatski
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-3">
                            <strong>Napomena:</strong> Sistem će automatski kreirati evidencijone listove za sve vrste otpada koje postoje u evidenciji otpada za izabranu firmu i godinu. Već postojeći listovi će biti preskočeni.
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="mb-6 flex items-center">
            <div class="flex-1 border-t border-gray-300"></div>
            <div class="px-4 text-sm text-gray-500 font-medium">ILI</div>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <!-- Manual Form -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Ručno dodavanje evidencijong lista</h2>
            <p class="text-sm text-gray-600">Popunite formu ispod za ručno dodavanje evidencijong lista</p>
        </div>

        <!-- Form -->
        <form action="{{ route('waste-evidence-sheets.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company -->
                <div>
                    <label for="company_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Firma <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="company_id" 
                        id="company_id" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('company_id') border-red-500 @enderror"
                    >
                        <option value="">Izaberite firmu</option>
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

                <!-- Waste Type -->
                <div>
                    <label for="waste_type" class="block text-sm font-semibold text-gray-700 mb-2">
                        Vrsta otpada <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="waste_type" 
                        id="waste_type" 
                        value="{{ old('waste_type') }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('waste_type') border-red-500 @enderror"
                        placeholder="Npr. Plastika, Papir, Metal..."
                    >
                    @error('waste_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Godina -->
                <div>
                    <label for="godina" class="block text-sm font-semibold text-gray-700 mb-2">
                        Godina <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="godina" 
                        id="godina" 
                        value="{{ old('godina', date('Y')) }}" 
                        min="2000"
                        max="2100"
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('godina') border-red-500 @enderror"
                        placeholder="2024"
                    >
                    @error('godina')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ukupna kolicina -->
                <div>
                    <label for="ukupna_kolicina" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ukupna količina <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="ukupna_kolicina" 
                        id="ukupna_kolicina" 
                        value="{{ old('ukupna_kolicina') }}" 
                        step="0.01"
                        min="0"
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('ukupna_kolicina') border-red-500 @enderror"
                        placeholder="0.00"
                    >
                    @error('ukupna_kolicina')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jedinica mere -->
                <div>
                    <label for="jedinica_mere" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jedinica mere <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="jedinica_mere" 
                        id="jedinica_mere" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('jedinica_mere') border-red-500 @enderror"
                    >
                        <option value="">Izaberite jedinicu mere</option>
                        <option value="kg" {{ old('jedinica_mere') == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="t" {{ old('jedinica_mere') == 't' ? 'selected' : '' }}>t</option>
                        <option value="l" {{ old('jedinica_mere') == 'l' ? 'selected' : '' }}>l</option>
                        <option value="m3" {{ old('jedinica_mere') == 'm3' ? 'selected' : '' }}>m³</option>
                    </select>
                    @error('jedinica_mere')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opis -->
                <div class="md:col-span-2">
                    <label for="opis" class="block text-sm font-semibold text-gray-700 mb-2">
                        Opis / Napomena
                    </label>
                    <textarea 
                        name="opis" 
                        id="opis" 
                        rows="4"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('opis') border-red-500 @enderror"
                        placeholder="Dodatni opis ili napomena (opciono)"
                    >{{ old('opis') }}</textarea>
                    @error('opis')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('waste-evidence-sheets.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj
                </button>
            </div>
        </form>
    </div>

    <script>
        // Auto-fill form when company and year are selected
        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('company_id');
            const yearInput = document.getElementById('godina');
            const wasteTypeInput = document.getElementById('waste_type');
            const kolicinaInput = document.getElementById('ukupna_kolicina');
            const jedinicaSelect = document.getElementById('jedinica_mere');

            function loadWasteTypes() {
                const companyId = companySelect.value;
                const year = yearInput.value;

                if (!companyId || !year) {
                    return;
                }

                // Show loading state
                wasteTypeInput.disabled = true;
                wasteTypeInput.placeholder = 'Učitavanje...';

                fetch(`{{ route('waste-evidence-sheets.get-waste-types') }}?company_id=${companyId}&year=${year}`)
                    .then(response => response.json())
                    .then(data => {
                        wasteTypeInput.disabled = false;
                        
                        if (data.length > 0) {
                            // Create a datalist for autocomplete
                            let datalist = document.getElementById('waste-types-datalist');
                            if (!datalist) {
                                datalist = document.createElement('datalist');
                                datalist.id = 'waste-types-datalist';
                                wasteTypeInput.setAttribute('list', 'waste-types-datalist');
                                document.body.appendChild(datalist);
                            }
                            
                            datalist.innerHTML = '';
                            data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.type;
                                option.textContent = `${item.type} (${item.total} ${item.unit})`;
                                datalist.appendChild(option);
                            });

                            wasteTypeInput.placeholder = 'Izaberite vrstu otpada ili unesite novu...';
                            
                            // Add event listener to auto-fill quantity when type is selected
                            wasteTypeInput.addEventListener('change', function() {
                                const selectedType = data.find(item => item.type === this.value);
                                if (selectedType) {
                                    kolicinaInput.value = selectedType.total.toFixed(2);
                                    jedinicaSelect.value = selectedType.unit;
                                }
                            });
                        } else {
                            wasteTypeInput.placeholder = 'Npr. Plastika, Papir, Metal...';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading waste types:', error);
                        wasteTypeInput.disabled = false;
                        wasteTypeInput.placeholder = 'Npr. Plastika, Papir, Metal...';
                    });
            }

            // Load waste types when company or year changes
            companySelect.addEventListener('change', loadWasteTypes);
            yearInput.addEventListener('change', loadWasteTypes);
        });
    </script>
@endsection

