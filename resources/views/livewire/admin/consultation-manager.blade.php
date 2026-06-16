<div x-data="{ tab: @entangle('activeTab') }">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Atender cita</h3>
                        <p class="text-sm text-gray-500">
                            Paciente: <span class="font-medium text-gray-700">{{ $appointment->patient->user->name ?? 'N/A' }}</span> |
                            Doctor: <span class="font-medium text-gray-700">{{ $appointment->doctor->name ?? 'N/A' }}</span> |
                            Fecha: <span class="font-medium text-gray-700">{{ $appointment->date->format('d/m/Y') }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.patients.edit', $appointment->patient) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                        <i class="fa-solid fa-file-medical mr-2"></i> Ver / Editar Historia médica
                    </a>
                    <button type="button" wire:click="openPreviousModal"
                            class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-sm font-semibold rounded-lg transition">
                        <i class="fa-solid fa-clock-rotate-left mr-2"></i> Consultas Anteriores
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex space-x-1 border-b border-gray-200 mb-6">
            @php
                $consultErrors = $errors->hasAny(['diagnosis', 'treatment', 'notes']);
                $prescriptionErrors = $errors->hasAny(['medications', 'medications.*.medication_name', 'medications.*.dosage', 'medications.*.frequency', 'medications.*.duration']);
            @endphp
            <button type="button"
                    @click="tab = 'consulta'"
                    :class="tab === 'consulta' ? ($consultErrors ? 'border-b-2 border-red-500 text-red-500' : 'border-b-2 border-indigo-600 text-indigo-600') : 'border-b-2 border-transparent text-gray-500'"
                    class="flex items-center space-x-2 px-4 py-3 text-sm font-medium transition">
                <i class="fa-solid fa-user-doctor"></i>
                <span>Consulta</span>
                @if($consultErrors)
                    <i class="fa-solid fa-circle-exclamation text-red-500 ml-1"></i>
                @endif
            </button>
            <button type="button"
                    @click="tab = 'receta'"
                    :class="tab === 'receta' ? ($prescriptionErrors ? 'border-b-2 border-red-500 text-red-500' : 'border-b-2 border-indigo-600 text-indigo-600') : 'border-b-2 border-transparent text-gray-500'"
                    class="flex items-center space-x-2 px-4 py-3 text-sm font-medium transition">
                <i class="fa-solid fa-pills"></i>
                <span>Receta</span>
                @if($prescriptionErrors)
                    <i class="fa-solid fa-circle-exclamation text-red-500 ml-1"></i>
                @endif
            </button>
        </div>

        {{-- Tab: Consulta --}}
        <div x-show="tab === 'consulta'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Diagnóstico <span class="text-red-500">*</span></label>
                    <textarea wire:model="diagnosis" rows="4"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('diagnosis') border-red-500 @enderror"></textarea>
                    @error('diagnosis')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tratamiento <span class="text-red-500">*</span></label>
                    <textarea wire:model="treatment" rows="4"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('treatment') border-red-500 @enderror"></textarea>
                    @error('treatment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notas</label>
                    <textarea wire:model="notes" rows="3"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror"></textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Tab: Receta --}}
        <div x-show="tab === 'receta'" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            @error('medications')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror

            @foreach($medications as $index => $medication)
                <div class="border border-gray-200 rounded-lg p-4 mb-4 bg-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-sm font-semibold text-gray-700">Medicamento #{{ $index + 1 }}</h4>
                        @if(count($medications) > 1)
                            <button type="button" wire:click="removeMedication({{ $index }})"
                                    class="text-red-500 hover:text-red-700 text-sm">
                                <i class="fa-solid fa-trash"></i> Eliminar
                            </button>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nombre <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="medications.{{ $index }}.medication_name"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('medications.'.$index.'.medication_name') border-red-500 @enderror">
                            @error('medications.'.$index.'.medication_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Dosis <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="medications.{{ $index }}.dosage"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('medications.'.$index.'.dosage') border-red-500 @enderror">
                            @error('medications.'.$index.'.dosage')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Frecuencia <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="medications.{{ $index }}.frequency"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('medications.'.$index.'.frequency') border-red-500 @enderror">
                            @error('medications.'.$index.'.frequency')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Duración <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="medications.{{ $index }}.duration"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('medications.'.$index.'.duration') border-red-500 @enderror">
                            @error('medications.'.$index.'.duration')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Instrucciones</label>
                            <textarea wire:model="medications.{{ $index }}.instructions" rows="2"
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('medications.'.$index.'.instructions') border-red-500 @enderror"></textarea>
                            @error('medications.'.$index.'.instructions')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="button" wire:click="addMedication"
                    class="inline-flex items-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-lg transition">
                <i class="fa-solid fa-plus mr-2"></i> Agregar medicamento
            </button>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end mt-8 space-x-3">
            <a href="{{ route('admin.appointments.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                Volver a citas
            </a>
            <button type="button" wire:click="save"
                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow flex items-center space-x-2">
                <i class="fa-solid fa-check"></i>
                <span>Guardar consulta</span>
            </button>
        </div>
    </div>

    {{-- Modal: Consultas Anteriores --}}
    @if($showPreviousModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closePreviousModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-600"></i> Consultas Anteriores
                            </h3>
                            <button type="button" wire:click="closePreviousModal" class="text-gray-400 hover:text-gray-500">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                        </div>
                        @if(count($previousConsultations) > 0)
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach($previousConsultations as $prev)
                                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-semibold text-gray-700">
                                                {{ $prev->appointment->date->format('d/m/Y') }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                Dr. {{ $prev->appointment->doctor->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <p class="text-xs font-semibold text-gray-500 uppercase">Diagnóstico</p>
                                            <p class="text-sm text-gray-800">{{ $prev->diagnosis }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 uppercase">Tratamiento</p>
                                            <p class="text-sm text-gray-800">{{ $prev->treatment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                <p>No hay consultas anteriores registradas para este paciente.</p>
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="closePreviousModal"
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
