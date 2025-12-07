@extends('layouts.app')

@section('title', 'Izmeni otpad - EcoFlow')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Izmeni otpad</h1>
            <p class="mt-2 text-sm text-gray-600">Ažurirajte podatke o otpadu</p>
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
        <form action="{{ route('wastes.update', $waste) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('company_id') border-red-500 @enderror"
                    >
                        <option value="">Izaberite kompaniju</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $waste->company_id) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Lokacija <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="location_id" 
                        id="location_id" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('location_id') border-red-500 @enderror"
                    >
                        <option value="">Izaberite lokaciju</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ old('location_id', $waste->location_id) == $location->id ? 'selected' : '' }}>
                                {{ $location->naziv }}
                            </option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tip otpada -->
                <div>
                    <label for="tip_otpada" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tip otpada <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="tip_otpada" 
                        id="tip_otpada" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('tip_otpada') border-red-500 @enderror"
                    >
                        <option value="">Izaberite tip</option>
                        <option value="Papir" {{ old('tip_otpada', $waste->tip_otpada) == 'Papir' ? 'selected' : '' }}>Papir</option>
                        <option value="Plastika" {{ old('tip_otpada', $waste->tip_otpada) == 'Plastika' ? 'selected' : '' }}>Plastika</option>
                        <option value="Metal" {{ old('tip_otpada', $waste->tip_otpada) == 'Metal' ? 'selected' : '' }}>Metal</option>
                        <option value="Elektronski otpad" {{ old('tip_otpada', $waste->tip_otpada) == 'Elektronski otpad' ? 'selected' : '' }}>Elektronski otpad</option>
                        <option value="Staklo" {{ old('tip_otpada', $waste->tip_otpada) == 'Staklo' ? 'selected' : '' }}>Staklo</option>
                        <option value="Bio otpad" {{ old('tip_otpada', $waste->tip_otpada) == 'Bio otpad' ? 'selected' : '' }}>Bio otpad</option>
                        <option value="Ostalo" {{ old('tip_otpada', $waste->tip_otpada) == 'Ostalo' ? 'selected' : '' }}>Ostalo</option>
                    </select>
                    @error('tip_otpada')
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
                        value="{{ old('kolicina', $waste->kolicina) }}" 
                        required
                        step="0.01"
                        min="0.01"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('kolicina') border-red-500 @enderror"
                        placeholder="0.00"
                    >
                    @error('kolicina')
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
                        value="{{ old('datum_nastanka', $waste->datum_nastanka->format('Y-m-d')) }}" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('datum_nastanka') border-red-500 @enderror"
                    >
                    @error('datum_nastanka')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status info (read-only) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Status
                    </label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-700">
                        @if($waste->status === 'Prijavljen')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Prijavljen
                            </span>
                        @elseif($waste->status === 'U obradi')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                U obradi
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Preuzet
                            </span>
                        @endif
                        <p class="text-xs text-gray-500 mt-2">Status se može menjati samo preko modula za preuzimanje.</p>
                    </div>
                </div>

                <!-- Napomena -->
                <div class="md:col-span-2">
                    <label for="napomena" class="block text-sm font-semibold text-gray-700 mb-2">
                        Napomena
                    </label>
                    <textarea 
                        name="napomena" 
                        id="napomena" 
                        rows="4"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 @error('napomena') border-red-500 @enderror"
                        placeholder="Dodatne napomene o otpadu..."
                    >{{ old('napomena', $waste->napomena) }}</textarea>
                    @error('napomena')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('wastes.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-colors duration-200">
                    Otkaži
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-xl font-semibold hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sačuvaj
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript for filtering locations -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const companySelect = document.getElementById('company_id');
            const locationSelect = document.getElementById('location_id');
            const allLocations = @json(\App\Models\Location::all()->groupBy('company_id'));

            companySelect.addEventListener('change', function() {
                const companyId = this.value;
                
                // Clear location select
                locationSelect.innerHTML = '<option value="">Izaberite lokaciju</option>';
                
                if (companyId && allLocations[companyId]) {
                    allLocations[companyId].forEach(function(location) {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.naziv;
                        locationSelect.appendChild(option);
                    });
                }
                
                // Restore selected location if it belongs to the new company
                const oldLocationId = @json(old('location_id', $waste->location_id));
                if (oldLocationId && allLocations[companyId]) {
                    const locationExists = allLocations[companyId].some(loc => loc.id == oldLocationId);
                    if (locationExists) {
                        locationSelect.value = oldLocationId;
                    }
                }
            });

            // Trigger change on load if company is selected
            if (companySelect.value) {
                companySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection

