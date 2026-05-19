<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return view('layouts.includes.admin.patients.index');
    }

    public function create()
    {
        return view('layouts.includes.admin.patients.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Patient $patient)
    {
        $patient->load('user');
        $user = $patient->user;

        return view('layouts.includes.admin.patients.show', compact('patient', 'user'));
    }

    public function edit(Patient $patient)
    {
        $patient->load('user');
        $user = $patient->user;
        $bloodTypes = \App\Models\BloodType::all();

        return view('layouts.includes.admin.patients.edit', compact('patient', 'user', 'bloodTypes'));
    }

    public function update(Request $request, Patient $patient)
{
    $request->validate([
        'blood_type_id'                   => ['nullable', 'exists:blood_types,id'],
        'allergies'                       => ['nullable', 'string', 'min:3', 'max:10'],
        'chronic_conditions'              => ['nullable', 'string', 'min:3', 'max:500'],
        'surgical_history'                => ['nullable', 'string', 'min:3', 'max:500'],
        'family_history'                  => ['nullable', 'string', 'min:3', 'max:500'],
        'observations'                    => ['nullable', 'string', 'min:3', 'max:1000'],
        'emergency_contact_name'          => ['nullable', 'string', 'min:3', 'max:100'],
        'emergency_contact_phone'         => ['nullable', 'string', 'max:20', 'min:10', 'regex:/^[0-9\s\(\)\-\+]+$/'],
        'emergency_contact_relationships' => ['nullable', 'string', 'min:3', 'max:50'],
    ], [
        'blood_type_id.exists'                    => 'El tipo de sangre seleccionado no es válido.',
        'allergies.min'                           => 'Las alergias deben tener al menos 3 caracteres.',
        'allergies.max'                           => 'Las alergias no pueden superar 500 caracteres.',
        'chronic_conditions.min'                  => 'Las condiciones crónicas deben tener al menos 3 caracteres.',
        'chronic_conditions.max'                  => 'Las condiciones crónicas no pueden superar 500 caracteres.',
        'surgical_history.min'                    => 'El historial quirúrgico debe tener al menos 3 caracteres.',
        'surgical_history.max'                    => 'El historial quirúrgico no puede superar 500 caracteres.',
        'family_history.min'                      => 'El historial familiar debe tener al menos 3 caracteres.',
        'family_history.max'                      => 'El historial familiar no puede superar 500 caracteres.',
        'observations.min'                        => 'Las observaciones deben tener al menos 3 caracteres.',
        'observations.max'                        => 'Las observaciones no pueden superar 1000 caracteres.',
        'emergency_contact_name.min'              => 'El nombre del contacto debe tener al menos 3 caracteres.',
        'emergency_contact_name.max'              => 'El nombre del contacto no puede superar 100 caracteres.',
        'emergency_contact_phone.min'             => 'El teléfono debe tener al menos 10 caracteres.',
        'emergency_contact_phone.max'             => 'El teléfono no puede superar 20 caracteres.',
        'emergency_contact_phone.regex'           => 'El teléfono solo puede contener números, espacios, paréntesis, guiones o +.',
        'emergency_contact_relationships.min'     => 'La relación debe tener al menos 3 caracteres.',
        'emergency_contact_relationships.max'     => 'La relación no puede superar 50 caracteres.',
    ]);

    $patient->update([
        'blood_type_id'                   => $request->blood_type_id,
        'allergies'                       => $request->allergies,
        'chronic_conditions'              => $request->chronic_conditions,
        'surgical_history'                => $request->surgical_history,
        'family_history'                  => $request->family_history,
        'observations'                    => $request->observations,
        'emergency_contact_name'          => $request->emergency_contact_name,
        'emergency_contact_phone'         => $request->emergency_contact_phone,
        'emergency_contact_relationships' => $request->emergency_contact_relationships,
    ]);

    return redirect()->route('admin.patients.edit', $patient)
        ->with('swal', [
            'title' => '¡Guardado!',
            'text'  => 'Paciente actualizado correctamente.',
            'icon'  => 'success',
        ]);
}

    public function destroy(Patient $patient)
    {
        //
    }
}
