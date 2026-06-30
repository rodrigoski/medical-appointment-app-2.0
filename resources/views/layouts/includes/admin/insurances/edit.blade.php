<x-admin-layout>
    <x-slot name="title">Editar Seguro</x-slot>

    <div class="container mx-auto px-6 py-4">

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                    <i class="fa-solid fa-shield-heart"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $insurance->name ?? 'Editar Seguro' }}</h3>
                    <p class="text-sm text-gray-500">Actualiza la información del convenio o seguro médico</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.insurances.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                    Volver
                </a>
                <button form="insurance-form" type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow flex items-center space-x-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Guardar cambios</span>
                </button>
            </div>
        </div>

        <form id="insurance-form" action="{{ route('admin.insurances.update', $insurance) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre del seguro *</label>
                        <input type="text" name="name" maxlength="150"
                               value="{{ old('name', $insurance->name) }}"
                               placeholder="Ej: Seguro Médico Integral"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Proveedor --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Proveedor / Aseguradora</label>
                        <input type="text" name="provider" maxlength="150"
                               value="{{ old('provider', $insurance->provider) }}"
                               placeholder="Ej: Aseguradora Nacional"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('provider') border-red-500 @enderror">
                        @error('provider')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Número de Póliza --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Número de Póliza</label>
                        <input type="text" name="policy_number" maxlength="100"
                               value="{{ old('policy_number', $insurance->policy_number) }}"
                               placeholder="Ej: POL-123456789"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('policy_number') border-red-500 @enderror">
                        @error('policy_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tipo de Cobertura --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Cobertura</label>
                        <input type="text" name="coverage_type" maxlength="100"
                               value="{{ old('coverage_type', $insurance->coverage_type) }}"
                               placeholder="Ej: Completa, Básica, Premium"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('coverage_type') border-red-500 @enderror">
                        @error('coverage_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono de contacto</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $insurance->phone) }}"
                               placeholder="Ej: 8095551234"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Correo electrónico</label>
                        <input type="email" name="email" maxlength="150"
                               value="{{ old('email', $insurance->email) }}"
                               placeholder="Ej: contacto@aseguradora.com"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
                        <select name="status"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                            <option value="1" {{ old('status', $insurance->status) == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('status', $insurance->status) == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Descripción --}}
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción</label>
                    <textarea name="description" rows="4" maxlength="2000"
                              placeholder="Descripción del seguro, beneficios, observaciones..."
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $insurance->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </form>
    </div>
</x-admin-layout>
