<x-admin-layout
    title="Usuarios"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Usuarios',
        ],
    ]"
>
    <x-slot name="action">
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
            <i class="fa-solid fa-plus mr-2"></i> Nuevo Usuario
        </a>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <x-wire-card>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="w-full h-12 border-gray-300 border-b py-8 text-left">
                                <th class="px-6 py-3 text-gray-600 font-bold text-xs uppercase tracking-wider">ID Personal</th>
                                <th class="px-6 py-3 text-gray-600 font-bold text-xs uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-gray-600 font-bold text-xs uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-gray-600 font-bold text-xs uppercase tracking-wider">Rol</th>
                                <th class="px-6 py-3 text-gray-600 font-bold text-xs uppercase tracking-wider text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->id_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->roles->isEmpty() ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $user->getRoleNames()->first() ?? 'Sin Rol' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex justify-center items-center space-x-3">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </a>

                                        {{-- Usamos la clase delete-form para activar el SweetAlert de tu layout --}}
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </x-wire-card>
        </div>
    </div>
</x-admin-layout>
