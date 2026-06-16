<div class="flex items-center space-x-2">
    <a href="{{ route('admin.appointments.consult', $appointment) }}"
       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
        <i class="fa-solid fa-stethoscope mr-1"></i> Atender
    </a>
    <a href="{{ route('admin.appointments.edit', $appointment) }}"
       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <i class="fa-solid fa-user-pen mr-1"></i> Editar
    </a>
    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            <i class="fa-solid fa-trash mr-1"></i> Eliminar
        </button>
    </form>
</div>
