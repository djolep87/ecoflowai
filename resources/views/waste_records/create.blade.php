@extends('layouts.app')

@section('title', 'Dodaj zapis evidencije otpada - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Dodaj novi zapis evidencije otpada</h1>
            <p class="mt-2 text-sm text-gray-600">Popunite formu sa podacima o otpadu</p>
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
        <form action="{{ route('waste-records.store') }}" method="POST" class="space-y-6">
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
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('company_id') border-red-500 @enderror"
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
                        Operator
                    </label>
                    <select 
                        name="operator_id" 
                        id="operator_id"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('operator_id') border-red-500 @enderror"
                    >
                        <option value="">Izaberite operatora (opciono)</option>
                        @foreach($operators as $operator)
                            <option value="{{ $operator->id }}" {{ old('operator_id') == $operator->id ? 'selected' : '' }}>
                                {{ $operator->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('operator_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Waste Type -->
                <div>
                    <label for="waste_type" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tip otpada <span class="text-red-500">*</span>
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

                <!-- Kolicina -->
                <div>
                    <label for="kolicina" class="block text-sm font-semibold text-gray-700 mb-2">
                        Količina <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="kolicina" 
                        id="kolicina" 
                        value="{{ old('kolicina') }}" 
                        step="0.01"
                        min="0"
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('kolicina') border-red-500 @enderror"
                        placeholder="0.00"
                    >
                    @error('kolicina')
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

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('status') border-red-500 @enderror"
                    >
                        <option value="">Izaberite status</option>
                        <option value="nastao" {{ old('status') == 'nastao' ? 'selected' : '' }}>Nastao</option>
                        <option value="spreman_za_predaju" {{ old('status') == 'spreman_za_predaju' ? 'selected' : '' }}>Spreman za predaju</option>
                        <option value="predat" {{ old('status') == 'predat' ? 'selected' : '' }}>Predat</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Datum nastanka -->
                <div>
                    <label for="datum_nastanka" class="block text-sm font-semibold text-gray-700 mb-2">
                        Datum nastanka <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="datum_nastanka" 
                        id="datum_nastanka" 
                        value="{{ old('datum_nastanka') }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('datum_nastanka') border-red-500 @enderror"
                    >
                    @error('datum_nastanka')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Datum predaje -->
                <div>
                    <label for="datum_predaje" class="block text-sm font-semibold text-gray-700 mb-2">
                        Datum predaje
                    </label>
                    <input 
                        type="date" 
                        name="datum_predaje" 
                        id="datum_predaje" 
                        value="{{ old('datum_predaje') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('datum_predaje') border-red-500 @enderror"
                    >
                    @error('datum_predaje')
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
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 @error('opis') border-red-500 @enderror"
                        placeholder="Dodatni opis otpada (opciono)"
                    >{{ old('opis') }}</textarea>
                    @error('opis')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('waste-records.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
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
        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('company_id');
            const wasteTypeInput = document.getElementById('waste_type');
            const jedinicaSelect = document.getElementById('jedinica_mere');
            const datumNastankaInput = document.getElementById('datum_nastanka');

            // Create datalist for autocomplete
            let datalist = document.createElement('datalist');
            datalist.id = 'waste-types-datalist';
            wasteTypeInput.setAttribute('list', 'waste-types-datalist');
            document.body.appendChild(datalist);

            // Load waste types when company is selected
            function loadWasteTypes() {
                const companyId = companySelect.value;
                
                if (!companyId) {
                    datalist.innerHTML = '';
                    return;
                }

                fetch(`{{ route('api.waste-records.waste-types') }}?company_id=${companyId}`)
                    .then(response => response.json())
                    .then(data => {
                        datalist.innerHTML = '';
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.type;
                            option.textContent = `${item.type} (${item.unit})`;
                            option.dataset.unit = item.unit;
                            datalist.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading waste types:', error);
                    });
            }

            // Auto-fill unit when waste type is selected
            wasteTypeInput.addEventListener('input', function() {
                const selectedOption = Array.from(datalist.options).find(
                    option => option.value === this.value
                );
                
                if (selectedOption && selectedOption.dataset.unit) {
                    jedinicaSelect.value = selectedOption.dataset.unit;
                }
            });

            // Set default date to today
            if (datumNastankaInput && !datumNastankaInput.value) {
                datumNastankaInput.value = new Date().toISOString().split('T')[0];
            }

            // Load waste types on company change
            companySelect.addEventListener('change', loadWasteTypes);
            
            // Load on page load if company is already selected
            if (companySelect.value) {
                loadWasteTypes();
            }
        });
    </script>
@endsection

