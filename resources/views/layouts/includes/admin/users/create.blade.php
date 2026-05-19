<x-admin-layout
    title="Nuevo Usuario"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Usuarios', 'href' => route('admin.users.index')],
        ['name' => 'Nuevo Usuario'],
    ]"
>
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-wire-card>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- ID Personal -->
                        <div>
                            <x-label for="id_number" value="ID Personal" />
                            <x-input id="id_number" name="id_number" type="text" class="mt-1 block w-full" value="{{ old('id_number') }}" required />
                            <x-input-error for="id_number" />
                        </div>

                        <!-- Nombre -->
                        <div>
                            <x-label for="name" value="Nombre Completo" />
                            <x-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required />
                            <x-input-error for="name" />
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <x-label for="email" value="Correo Electrónico" />
                            <x-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email') }}" required />
                            <x-input-error for="email" />
                        </div>

                        <!-- Rol (Spatie) -->
                        <div class="md:col-span-2">
                            <x-label for="role" value="Asignar Rol" />
                            <select name="role" id="role" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error for="role" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-label for="password" value="Contraseña" />
                            <x-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                            <x-input-error for="password" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-label for="password_confirmation" value="Confirmar Contraseña" />
                            <x-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <x-button class="bg-blue-600 hover:bg-blue-700">
                            <i class="fa-solid fa-save mr-2"></i> Guardar Usuario
                        </x-button>
                    </div>
                </form>
            </x-wire-card>
        </div>
    </div>
</x-admin-layout>
