<x-admin-layout
    title="Patients"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Pacientes',
        ],
    ]"
>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-wire-card>
                <livewire:admin.datatables.patient-table />
            </x-wire-card>
        </div>
    </div>
</x-admin-layout>
