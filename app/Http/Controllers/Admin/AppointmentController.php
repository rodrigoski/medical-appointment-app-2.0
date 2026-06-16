<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('layouts.includes.admin.appointments.index');
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::all();
        return view('layouts.includes.admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'reason' => ['required', 'string', 'min:3', 'max:1000'],
            'duration' => ['nullable', 'integer', 'min:1'],
        ], [
            'patient_id.required' => 'El paciente es obligatorio.',
            'doctor_id.required' => 'El doctor es obligatorio.',
            'date.required' => 'La fecha es obligatoria.',
            'date.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'end_time.required' => 'La hora de término es obligatoria.',
            'end_time.after' => 'La hora de término debe ser posterior a la hora de inicio.',
            'reason.required' => 'El motivo de la consulta es obligatorio.',
            'reason.min' => 'El motivo debe tener al menos 3 caracteres.',
            'reason.max' => 'El motivo no puede superar 1000 caracteres.',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'duration' => $validated['duration'] ?? 15,
            'reason' => $validated['reason'],
            'status' => 1,
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'title' => '¡Cita creada!',
                'text' => 'La cita se registró correctamente.',
                'icon' => 'success',
            ]);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor', 'consultation.prescriptions']);
        return view('layouts.includes.admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor']);
        $patients = Patient::with('user')->get();
        $doctors = Doctor::all();
        return view('layouts.includes.admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'reason' => ['required', 'string', 'min:3', 'max:1000'],
            'duration' => ['nullable', 'integer', 'min:1'],
        ], [
            'patient_id.required' => 'El paciente es obligatorio.',
            'doctor_id.required' => 'El doctor es obligatorio.',
            'date.required' => 'La fecha es obligatoria.',
            'date.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
            'start_time.required' => 'La hora de inicio es obligatoria.',
            'end_time.required' => 'La hora de término es obligatoria.',
            'end_time.after' => 'La hora de término debe ser posterior a la hora de inicio.',
            'reason.required' => 'El motivo de la consulta es obligatorio.',
            'reason.min' => 'El motivo debe tener al menos 3 caracteres.',
            'reason.max' => 'El motivo no puede superar 1000 caracteres.',
        ]);

        $appointment->update([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'duration' => $validated['duration'] ?? 15,
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'title' => '¡Cita actualizada!',
                'text' => 'Los cambios se guardaron correctamente.',
                'icon' => 'success',
            ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')
            ->with('swal', [
                'title' => '¡Eliminada!',
                'text' => 'La cita fue eliminada correctamente.',
                'icon' => 'success',
            ]);
    }

    public function consult(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor', 'consultation.prescriptions']);
        return view('layouts.includes.admin.appointments.consult', compact('appointment'));
    }
}
