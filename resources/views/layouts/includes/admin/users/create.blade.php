@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex flex-col">
        <div class="mb-4">
            {{-- Breadcrumbs para mejorar la navegación (UX) --}}
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
                    <li class="flex items-center text-blue-600">Nuevo Usuario</li>
                </ol>
            </nav>
            <h3 class="text-3xl font-medium text-gray-700">Registrar Nuevo Usuario</h3>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nombre Completo</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                               placeholder="Ej. Juan Pérez">
                        @error('name') <span class="text-red-500 text-sm italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Correo electrónico --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               placeholder="usuario@healthify.com">
                        @error('email') <span class="text-red-500 text-sm italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Número de ID (DNI/Cédula) --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Número de Identificación</label>
                        <input type="text" name="id_number" value="{{ old('id_number') }}"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('id_number') border-red-500 @enderror"
                               placeholder="ID Único">
                        @error('id_number') <span class="text-red-500 text-sm italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Teléfono de Contacto</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                               placeholder="999-000-0000">
                    </div>

                    {{-- Contraseña --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Contraseña</label>
                        <input type="password" name="password"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password') <span class="text-red-500 text-sm italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                {{-- Dirección --}}
                <div class="mt-6">
                    <label class="block text-gray-700 font-bold mb-2">Dirección de Domicilio</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
                           placeholder="Calle, Número, Colonia">
                </div>

                {{-- Selección de Rol (Spatie) --}}
                <div class="mt-6">
                    <label class="block text-gray-700 font-bold mb-2">Rol Asignado</label>
                    <select name="role" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror">
                        <option value="" disabled selected>Selecciona un rol...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-red-500 text-sm italic">{{ $message }}</span> @enderror
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition shadow-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition shadow-md">
                        Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
