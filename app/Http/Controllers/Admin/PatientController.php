<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Throwable;

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
        try {
            $patient->load('user');
            $user = $patient->user;

            if (!$user) {
                throw new \RuntimeException('Este paciente no tiene un usuario asociado.');
            }

            return view('layouts.includes.admin.patients.show', compact('patient', 'user'));

        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.patients.index')
                ->with('swal', [
                    'title' => 'No encontrado',
                    'text'  => 'El paciente solicitado no existe.',
                    'icon'  => 'error',
                ]);
        } catch (Throwable $e) {
            return redirect()->route('admin.patients.index')
                ->with('swal', [
                    'title' => 'Error inesperado',
                    'text'  => 'Ocurrió un problema al cargar el paciente.',
                    'icon'  => 'error',
                ]);
        }
    }

    public function edit(Patient $patient)
    {
        try {
            $patient->load('user');
            $user       = $patient->user;
            $bloodTypes = \App\Models\BloodType::all();

            if (!$user) {
                throw new \RuntimeException('Paciente sin usuario asociado.');
            }

            return view('layouts.includes.admin.patients.edit', compact('patient', 'user', 'bloodTypes'));

        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.patients.index')
                ->with('swal', [
                    'title' => 'No encontrado',
                    'text'  => 'El paciente no existe en el sistema.',
                    'icon'  => 'error',
                ]);
        } catch (Throwable $e) {
            return redirect()->route('admin.patients.index')
                ->with('swal', [
                    'title' => 'Error inesperado',
                    'text'  => 'No se pudo cargar el formulario de edición.',
                    'icon'  => 'error',
                ]);
        }
    }

    public function update(Request $request, Patient $patient)
    {
        try {
            $request->validate([
                'blood_type_id'                   => ['nullable', 'exists:blood_types,id'],
                'allergies'                       => ['nullable', 'string', 'min:3', 'max:500'],
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

        } catch (ValidationException $e) {
            // Laravel redirige automáticamente con errores, pero lo capturamos
            // por si se necesita logging adicional
            throw $e;

        } catch (QueryException $e) {
            return redirect()->back()->withInput()
                ->with('swal', [
                    'title' => 'Error de base de datos',
                    'text'  => 'No se pudieron guardar los cambios. Intenta de nuevo.',
                    'icon'  => 'error',
                ]);

        } catch (Throwable $e) {
            return redirect()->back()->withInput()
                ->with('swal', [
                    'title' => 'Error inesperado',
                    'text'  => 'Ocurrió un problema al actualizar el paciente.',
                    'icon'  => 'error',
                ]);
        }
    }

    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();

            return redirect()->route('admin.patients.index')
                ->with('swal', [
                    'title' => '¡Eliminado!',
                    'text'  => 'Paciente eliminado correctamente.',
                    'icon'  => 'success',
                ]);

        } catch (QueryException $e) {
            return redirect()->back()
                ->with('swal', [
                    'title' => 'Error al eliminar',
                    'text'  => 'No se pudo eliminar el paciente. Puede tener registros relacionados.',
                    'icon'  => 'error',
                ]);

        } catch (Throwable $e) {
            return redirect()->back()
                ->with('swal', [
                    'title' => 'Error inesperado',
                    'text'  => 'Ocurrió un problema al eliminar el paciente.',
                    'icon'  => 'error',
                ]);
        }
    }
}
