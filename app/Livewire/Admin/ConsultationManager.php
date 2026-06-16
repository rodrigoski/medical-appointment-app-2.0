<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Prescription;
use Livewire\Component;

class ConsultationManager extends Component
{
    public Appointment $appointment;

    public $activeTab = 'consulta';

    public $diagnosis = '';
    public $treatment = '';
    public $notes = '';

    public $medications = [
        ['medication_name' => '', 'dosage' => '', 'frequency' => '', 'duration' => '', 'instructions' => ''],
    ];

    public $showPreviousModal = false;
    public $previousConsultations = [];

    protected function rules(): array
    {
        return [
            'diagnosis' => ['required', 'string', 'min:3'],
            'treatment' => ['required', 'string', 'min:3'],
            'notes' => ['nullable', 'string'],
            'medications' => ['required', 'array', 'min:1'],
            'medications.*.medication_name' => ['required', 'string', 'min:2'],
            'medications.*.dosage' => ['required', 'string', 'min:1'],
            'medications.*.frequency' => ['required', 'string', 'min:1'],
            'medications.*.duration' => ['required', 'string', 'min:1'],
            'medications.*.instructions' => ['nullable', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'diagnosis.required' => 'El diagnóstico es obligatorio.',
            'diagnosis.min' => 'El diagnóstico debe tener al menos 3 caracteres.',
            'treatment.required' => 'El tratamiento es obligatorio.',
            'treatment.min' => 'El tratamiento debe tener al menos 3 caracteres.',
            'medications.required' => 'Debe agregar al menos un medicamento a la receta.',
            'medications.*.medication_name.required' => 'El nombre del medicamento es obligatorio.',
            'medications.*.dosage.required' => 'La dosis es obligatoria.',
            'medications.*.frequency.required' => 'La frecuencia es obligatoria.',
            'medications.*.duration.required' => 'La duración es obligatoria.',
        ];
    }

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;

        if ($appointment->consultation) {
            $this->diagnosis = $appointment->consultation->diagnosis;
            $this->treatment = $appointment->consultation->treatment;
            $this->notes = $appointment->consultation->notes;

            $existing = $appointment->consultation->prescriptions->toArray();
            if (count($existing) > 0) {
                $this->medications = $existing;
            }
        }
    }

    public function addMedication()
    {
        $this->medications[] = ['medication_name' => '', 'dosage' => '', 'frequency' => '', 'duration' => '', 'instructions' => ''];
    }

    public function removeMedication($index)
    {
        if (count($this->medications) > 1) {
            unset($this->medications[$index]);
            $this->medications = array_values($this->medications);
        }
    }

    public function openPreviousModal()
    {
        $this->previousConsultations = Consultation::with(['appointment.doctor', 'appointment.patient'])
            ->whereHas('appointment', function ($query) {
                $query->where('patient_id', $this->appointment->patient_id)
                      ->where('id', '!=', $this->appointment->id);
            })
            ->latest()
            ->get();

        $this->showPreviousModal = true;
    }

    public function closePreviousModal()
    {
        $this->showPreviousModal = false;
    }

    public function save()
    {
        $validated = $this->validate();

        $consultation = Consultation::updateOrCreate(
            ['appointment_id' => $this->appointment->id],
            [
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
                'notes' => $this->notes,
            ]
        );

        // Borrar recetas anteriores y recrear
        $consultation->prescriptions()->delete();
        foreach ($this->medications as $med) {
            $consultation->prescriptions()->create($med);
        }

        // Actualizar estado de la cita a completada (2)
        $this->appointment->update(['status' => 2]);

        session()->flash('swal', [
            'title' => '¡Guardado!',
            'text' => 'La consulta y receta se guardaron correctamente.',
            'icon' => 'success',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
