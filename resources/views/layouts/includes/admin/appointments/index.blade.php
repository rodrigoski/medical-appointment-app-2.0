<x-admin-layout
    title="Citas"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Citas',
        ],
    ]"
>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Botón Nueva Cita --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.appointments.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition space-x-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Nueva Cita</span>
                </a>
            </div>

            <x-wire-card>
                <livewire:admin.datatables.appointment-table />
            </x-wire-card>

        </div>
    </div>
</x-admin-layout>
