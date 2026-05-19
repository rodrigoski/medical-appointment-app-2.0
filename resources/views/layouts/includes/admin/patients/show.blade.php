<x-admin-layout
    title="Patients"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Patients',
            'href' =>  route('admin.patients.index'),
        ],
        [

            'name' => 'Detalle',

        ],
    ]"
>
</x-admin-layout>
