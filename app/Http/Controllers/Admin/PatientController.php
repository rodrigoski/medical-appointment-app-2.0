<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.includes.admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.includes.admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load('user');
        $user = $patient->user;

        return view('layouts.includes.admin.patients.show', compact('patient', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
{
    $patient->load('user');
    $user = $patient->user;
    $bloodTypes = \App\Models\BloodType::all();

    return view('layouts.includes.admin.patients.edit', compact('patient', 'user', 'bloodTypes'));
}

public function update(Request $request, Patient $patient)
{
    // Actualizar datos del usuario
    $patient->user->update([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->phone,
        'address'  => $request->address,
        'id_number'=> $request->id_number,
    ]);

    // Actualizar datos del paciente
    $patient->update([
        'blood_type_id'                  => $request->blood_type_id,
        'allergies'                      => $request->allergies,
        'chronic_conditions'             => $request->chronic_conditions,
        'surgical_history'               => $request->surgical_history,
        'family_history'                 => $request->family_history,
        'observations'                   => $request->observations,
        'emergency_contact_name'         => $request->emergency_contact_name,
        'emergency_contact_phone'        => $request->emergency_contact_phone,
        'emergency_contact_relationships'=> $request->emergency_contact_relationships,
    ]);

    return redirect()->route('admin.patients.index')
        ->with('swal', [
            'title' => '¡Guardado!',
            'text'  => 'Paciente actualizado correctamente.',
            'icon'  => 'success',
        ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
