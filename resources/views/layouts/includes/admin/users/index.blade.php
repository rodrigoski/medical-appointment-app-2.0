@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-3xl font-medium text-gray-700">Usuarios</h3>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow">
            + Nuevo Usuario
        </a>
    </div>

    <div class="bg-white shadow-md rounded-my-6 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="w-full h-16 border-gray-300 border-b py-8 text-left">
                    <th class="pl-8 text-gray-600 font-bold pr-6 text-sm uppercase">ID Personal</th>
                    <th class="text-gray-600 font-bold pr-6 text-sm uppercase">Nombre</th>
                    <th class="text-gray-600 font-bold pr-6 text-sm uppercase">Email</th>
                    <th class="text-gray-600 font-bold pr-6 text-sm uppercase">Rol</th>
                    <th class="text-gray-600 font-bold pr-6 text-sm uppercase text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="h-12 border-gray-300 border-b">
                    <td class="pl-8 pr-6 text-sm text-gray-800">{{ $user->id_number }}</td>
                    <td class="pr-6 text-sm text-gray-800">{{ $user->name }}</td>
                    <td class="pr-6 text-sm text-gray-800">{{ $user->email }}</td>
                    <td class="pr-6 text-sm">
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                            {{ $user->getRoleNames()->first() ?? 'Sin Rol' }}
                        </span>
                    </td>
                    <td class="pr-6 text-sm text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-4">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
