<x-admin-layout>
    <x-slot name="title">Editar Paciente: {{ $user->name }}</x-slot>

    <div class="container mx-auto px-6 py-4">

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">Editando perfil del paciente</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.patients.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                    Volver
                </a>
                <button form="patient-form" type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow flex items-center space-x-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Guardar cambios</span>
                </button>
            </div>
        </div>

        <form id="patient-form" action="{{ route('admin.patients.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')

            @php
                $activeTab = 'personal';
                if ($errors->hasAny(['allergies','chronic_conditions','surgical_history','family_history'])) {
                    $activeTab = 'antecedentes';
                } elseif ($errors->hasAny(['blood_type_id','observations'])) {
                    $activeTab = 'general';
                } elseif ($errors->hasAny(['emergency_contact_name','emergency_contact_phone','emergency_contact_relationships'])) {
                    $activeTab = 'emergencia';
                }
            @endphp

            <div x-data="{ tab: '{{ $activeTab }}' }">

            {{-- Navegación de pestañas --}}
                <x-admin-tabs
                    :tabs="[
                        ['key' => 'personal',     'icon' => 'fa-solid fa-user',         'label' => 'Datos personales'],
                        ['key' => 'antecedentes', 'icon' => 'fa-solid fa-file-medical', 'label' => 'Antecedentes'],
                        ['key' => 'general',      'icon' => 'fa-solid fa-circle-info',  'label' => 'Información general'],
                        ['key' => 'emergencia',   'icon' => 'fa-solid fa-heart-pulse',  'label' => 'Contacto de emergencia'],
                        ]"
                    :active="$activeTab"
                />

                {{-- Tab: Datos personales --}}
                <div x-show="tab === 'personal'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center justify-between bg-indigo-50 border-l-4 border-indigo-500 rounded-lg px-5 py-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="text-indigo-500 text-xl">
                                <i class="fa-solid fa-user-pen"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Edición de cuenta de usuario</p>
                                <p class="text-xs text-gray-500">
                                    La <span class="font-medium text-gray-700">información de acceso</span>
                                    (nombre, email y contraseña) debe gestionarse desde la cuenta de usuario asociada.
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.edit', $user) }}" target="_blank"
                           class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition">
                            <span>Editar usuario</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Teléfono</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->phone ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Email</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->email ?? '—' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Dirección</p>
                            <p class="text-sm font-medium text-gray-800">{{ $user->address ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tab: Antecedentes --}}
                <div x-show="tab === 'antecedentes'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alergias</label>
                            <textarea name="allergies" rows="3" maxlength="500"
                                      placeholder="Ej: Polen, Penicilina, Mariscos..."
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('allergies') border-red-500 @enderror">{{ old('allergies', $patient->allergies) }}</textarea>
                            @error('allergies')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Condiciones crónicas</label>
                            <textarea name="chronic_conditions" rows="3" maxlength="500"
                                      placeholder="Ej: Diabetes, Hipertensión..."
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('chronic_conditions') border-red-500 @enderror">{{ old('chronic_conditions', $patient->chronic_conditions) }}</textarea>
                            @error('chronic_conditions')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Historial quirúrgico</label>
                            <textarea name="surgical_history" rows="3" maxlength="500"
                                      placeholder="Ej: Apendicectomía 2015..."
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('surgical_history') border-red-500 @enderror">{{ old('surgical_history', $patient->surgical_history) }}</textarea>
                            @error('surgical_history')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Historial familiar</label>
                            <textarea name="family_history" rows="3" maxlength="500"
                                      placeholder="Ej: Diabetes hereditaria..."
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('family_history') border-red-500 @enderror">{{ old('family_history', $patient->family_history) }}</textarea>
                            @error('family_history')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Tab: Información general --}}
                <div x-show="tab === 'general'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Sangre</label>
                            <select name="blood_type_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('blood_type_id') border-red-500 @enderror">
                                <option value="">Selecciona un tipo de sangre</option>
                                @foreach($bloodTypes as $bloodType)
                                    <option value="{{ $bloodType->id }}"
                                        {{ old('blood_type_id', $patient->blood_type_id) == $bloodType->id ? 'selected' : '' }}>
                                        {{ $bloodType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('blood_type_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones</label>
                            <textarea name="observations" rows="4" maxlength="1000"
                                      placeholder="Escribe cualquier observación relevante..."
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('observations') border-red-500 @enderror">{{ old('observations', $patient->observations) }}</textarea>
                            @error('observations')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Tab: Contacto de emergencia --}}
                <div x-show="tab === 'emergencia'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre del contacto</label>
                            <input type="text" name="emergency_contact_name" maxlength="100"
                                   value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                   placeholder="Nombre completo del contacto"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('emergency_contact_name') border-red-500 @enderror">
                            @error('emergency_contact_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono del contacto</label>
                            <input type="text" name="emergency_contact_phone" maxlength="20"
                                   value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                                   placeholder="(999) 999-9999"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('emergency_contact_phone') border-red-500 @enderror">
                            @error('emergency_contact_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Relación con el contacto</label>
                            <input type="text" name="emergency_contact_relationships" maxlength="50"
                                   value="{{ old('emergency_contact_relationships', $patient->emergency_contact_relationships) }}"
                                   placeholder="Familiar, Amigo, etc."
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('emergency_contact_relationships') border-red-500 @enderror">
                            @error('emergency_contact_relationships')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>{{-- fin x-data --}}
        </form>
    </div>
</x-admin-layout>
