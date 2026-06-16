<x-admin-layout
    title="Horarios del Doctor"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Doctores',
            'href' => route('admin.doctors.index'),
        ],
        [
            'name' => 'Horarios',
        ],
    ]"
>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Horarios del Doctor</h2>
                        <p class="text-sm text-gray-500">{{ $doctor->name ?? 'N/A' }} - {{ $doctor->speciality->name ?? 'Sin especialidad' }}</p>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                El módulo de horarios automáticos aún no está implementado. Próximamente podrás gestionar los horarios de disponibilidad del doctor.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Horario actual</p>
                        <p class="text-sm text-gray-600">{{ $doctor->consultation_schedule ?? 'No se ha registrado un horario de consulta.' }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Sala de consulta</p>
                        <p class="text-sm text-gray-600">{{ $doctor->consultation_room ?? 'No se ha registrado una sala.' }}</p>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end">
                    <a href="{{ route('admin.doctors.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                        Volver a doctores
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
