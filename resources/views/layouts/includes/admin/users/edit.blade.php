<x-admin-layout>
    <x-slot name="title">
        Editar Usuario
    </x-slot>

    <div class="container mx-auto px-6 py-8">
        <div class="flex flex-col">
            <div class="mb-4">
                <h3 class="text-3xl font-medium text-gray-700">Editar Perfil: {{ $user->name }}</h3>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Correo electrónico --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Número de ID --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Número de ID</label>
                            <input type="text" name="id_number" value="{{ old('id_number', $user->id_number) }}"
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Contraseña --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nueva Contraseña</label>
                            <input type="password" name="password" placeholder="Opcional"
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Confirmar Contraseña --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-gray-700 font-bold mb-2">Dirección</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Roles --}}
                    <div class="mt-6">
                        <label class="block text-gray-700 font-bold mb-2">Rol</label>
                        <select name="role" class="w-full border rounded-lg px-4 py-2">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
