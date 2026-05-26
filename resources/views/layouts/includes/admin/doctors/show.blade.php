<x-admin-layout>
    <x-slot name="title">Doctor: {{ $user->name }}</x-slot>

    <div class="container mx-auto px-6 py-4">

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">Licencia: {{ $doctor->license_number ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.doctors.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                    Volver
                </a>
                <a href="{{ route('admin.doctors.edit', $doctor) }}"
                   class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow flex items-center space-x-2">
                    <i class="fa-solid fa-user-pen"></i>
                    <span>Editar</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Especialidad</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->speciality->name ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Número de licencia médica</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->license_number ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Teléfono</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->phone ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Años de experiencia</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->years_of_experience ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Consultorio</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->consultation_room ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Horario de consulta</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->consultation_schedule ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Formación académica</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->education ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Certificaciones</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->certifications ?? '—' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase mb-1">Biografía</p>
                    <p class="text-sm font-medium text-gray-800">{{ $doctor->biography ?? '—' }}</p>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
