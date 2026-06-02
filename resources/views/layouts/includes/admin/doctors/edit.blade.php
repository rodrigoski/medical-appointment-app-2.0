<x-admin-layout>
    <x-slot name="title">Editar Doctor</x-slot>

    <div class="container mx-auto px-6 py-4">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $doctor->name ?? 'Editar Doctor' }}</h3>
                    <p class="text-sm text-gray-500">Licencia: {{ $doctor->license_number ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.doctors.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                    Volver
                </a>
                <button form="doctor-form" type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow flex items-center space-x-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Guardar cambios</span>
                </button>
            </div>
        </div>

        {{-- Sección foto de perfil --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <p class="text-sm font-semibold text-gray-700 mb-4">Foto de perfil</p>
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <div id="photo-preview"
                         class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center overflow-hidden border-4 border-indigo-200">
                        <i class="fa-solid fa-user-doctor text-indigo-400 text-3xl"></i>
                    </div>
                </div>
                <div class="flex flex-col space-y-2">
                    <label for="photo-input"
                           class="cursor-pointer inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition">
                        <i class="fa-solid fa-upload"></i>
                        <span>Subir foto</span>
                    </label>
                    <input id="photo-input" type="file" accept="image/*" class="hidden"
                           onchange="previewPhoto(event)">
                    <p class="text-xs text-gray-400">JPG, PNG o WEBP. Máximo 2MB.</p>
                </div>
            </div>
        </div>

        <form id="doctor-form" action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="grid grid-cols-1 gap-6">

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre completo</label>
                        <input type="text" name="name" maxlength="100"
                               value="{{ old('name', $doctor->name) }}"
                               placeholder="Ej: Dr. Juan Pérez"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Especialidad --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Especialidad</label>
                        <select name="speciality_id"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('speciality_id') border-red-500 @enderror">
                            <option value="">Selecciona una especialidad</option>
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality->id }}"
                                    {{ old('speciality_id', $doctor->speciality_id) == $speciality->id ? 'selected' : '' }}>
                                    {{ $speciality->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('speciality_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Licencia --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Número de licencia médica</label>
                        <input type="text" name="license_number" maxlength="50"
                               value="{{ old('license_number', $doctor->license_number) }}"
                               placeholder="Ej: 12345678"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('license_number') border-red-500 @enderror">
                        @error('license_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Biografía --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Biografía</label>
                        <textarea name="biography" rows="4" maxlength="2000"
                                  placeholder="Breve descripción profesional del doctor..."
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('biography') border-red-500 @enderror">{{ old('biography', $doctor->biography) }}</textarea>
                        @error('biography')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photo-preview');
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-full">`;
            };
            reader.readAsDataURL(file);
        }
    </script>

</x-admin-layout>
