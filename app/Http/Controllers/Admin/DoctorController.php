<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return view('layouts.includes.admin.doctors.index');
    }

    public function create()
    {
        $specialities = Speciality::orderBy('name')->get();
        return view('layouts.includes.admin.doctors.create', compact('specialities'));
    }

   public function store(Request $request)
{
    $request->validate([
        'name'           => ['required', 'string', 'min:3', 'max:100'],
        'speciality_id'  => ['nullable', 'exists:specialities,id'],
        'license_number' => ['nullable', 'string', 'min:5', 'max:50'],
        'biography'      => ['nullable', 'string', 'min:3', 'max:2000'],
    ], [
        'name.required'      => 'El nombre del doctor es obligatorio.',
        'name.min'           => 'El nombre debe tener al menos 3 caracteres.',
        'name.max'           => 'El nombre no puede superar 100 caracteres.',
        'license_number.min' => 'La licencia debe tener al menos 5 caracteres.',
        'license_number.max' => 'La licencia no puede superar 50 caracteres.',
        'biography.min'      => 'La biografía debe tener al menos 3 caracteres.',
        'biography.max'      => 'La biografía no puede superar 2000 caracteres.',
    ]);

    $doctor = Doctor::create([
        'name'           => $request->name,
        'speciality_id'  => $request->speciality_id,
        'license_number' => $request->license_number,
        'biography'      => $request->biography,
    ]);

    return redirect()->route('admin.doctors.edit', $doctor)
        ->with('swal', [
            'title' => '¡Creado!',
            'text'  => 'Doctor creado correctamente.',
            'icon'  => 'success',
        ]);
}

    public function show(Doctor $doctor)
    {
        $doctor->load('user', 'speciality');
        $user = $doctor->user;

        return view('layouts.includes.admin.doctors.show', compact('doctor', 'user'));
    }

    public function edit(Doctor $doctor)
{
    $doctor->load('user', 'speciality');
    $user         = $doctor->user;
    $specialities = Speciality::orderBy('name')->get();

    return view('layouts.includes.admin.doctors.edit', compact('doctor', 'user', 'specialities'));
}

    public function update(Request $request, Doctor $doctor)
{
    $request->validate([
        'speciality_id'  => ['nullable', 'exists:specialities,id'],
        'license_number' => ['nullable', 'string', 'min:5', 'max:50'],
        'biography'      => ['nullable', 'string', 'min:3', 'max:2000'],
    ], [
        'license_number.min' => 'La licencia debe tener al menos 5 caracteres.',
        'license_number.max' => 'La licencia no puede superar 50 caracteres.',
        'biography.min'      => 'La biografía debe tener al menos 3 caracteres.',
        'biography.max'      => 'La biografía no puede superar 2000 caracteres.',
    ]);

    $doctor->update([
        'speciality_id'  => $request->speciality_id,
        'license_number' => $request->license_number,
        'biography'      => $request->biography,
    ]);

    return redirect()->route('admin.doctors.edit', $doctor)
        ->with('swal', [
            'title' => '¡Guardado!',
            'text'  => 'Doctor actualizado correctamente.',
            'icon'  => 'success',
        ]);
}

    public function destroy(Doctor $doctor)
{
    $doctor->delete();

    return redirect()->route('admin.doctors.index')
        ->with('swal', [
            'title' => '¡Eliminado!',
            'text'  => 'Doctor eliminado correctamente.',
            'icon'  => 'success',
        ]);
}

    public function schedules(Doctor $doctor)
    {
        return view('layouts.includes.admin.doctors.schedules', compact('doctor'));
    }
}
