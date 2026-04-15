@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex flex-col">
        <div class="mb-4">
            <nav class="text-sm font-semibold mb-2" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center text-gray-500">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="flex items-center text-gray-500">
                        <a href="{{ route('admin.users.index') }}">Usuarios</a>
                        <span class="mx-2">/</span>
                    </li>
                    <li class="flex items-center text-blue-600">Editar Usuario</li>
                </ol>
            </nav>
            <h3 class="text-3xl font-medium text-gray-700">Editar: {{ $user->name }}</h3>
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
                        @error('id_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Contraseña (Opcional) --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nueva Contraseña</label>
                        <input type="password" name="password" placeholder="Dejar en blanco para no cambiar"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres si desea cambiarla.</p>
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation" placeholder="Repita la nueva contraseña"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Dirección --}}
                <div class="mt-6">
                    <label class="block text-gray-700 font-bold mb-2">Dirección</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Rol --}}
                <div class="mt-6">
                    <label class="block text-gray-700 font-bold mb-2">Rol del Sistema</label>
                    <select name="role" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
