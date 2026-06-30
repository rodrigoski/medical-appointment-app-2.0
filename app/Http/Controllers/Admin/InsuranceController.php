<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Throwable;

class InsuranceController extends Controller
{
    public function index()
    {
        return view('layouts.includes.admin.insurances.index');
    }

    public function create()
    {
        return view('layouts.includes.admin.insurances.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'           => ['required', 'string', 'min:2', 'max:150'],
                'provider'       => ['nullable', 'string', 'min:2', 'max:150'],
                'policy_number'  => ['nullable', 'string', 'max:100', 'unique:insurances,policy_number'],
                'coverage_type'  => ['nullable', 'string', 'max:100'],
                'phone'          => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^[0-9]+$/'],
                'email'          => ['nullable', 'email', 'max:150'],
                'status'         => ['boolean'],
                'description'    => ['nullable', 'string', 'max:2000'],
            ], [
                'name.required' => 'El nombre del seguro es obligatorio.',
                'name.min'      => 'El nombre debe tener al menos 2 caracteres.',
                'name.max'      => 'El nombre no puede superar 150 caracteres.',
                'provider.min'  => 'El proveedor debe tener al menos 2 caracteres.',
                'provider.max'  => 'El proveedor no puede superar 150 caracteres.',
                'policy_number.max' => 'El número de póliza no puede superar 100 caracteres.',
                'policy_number.unique' => 'Este número de póliza ya está registrado.',
                'coverage_type.max' => 'El tipo de cobertura no puede superar 100 caracteres.',
                'phone.min'     => 'El teléfono debe tener al menos 10 caracteres.',
                'phone.max'     => 'El teléfono no puede superar 10 caracteres.',
                'phone.regex'   => 'El teléfono solo puede contener números.',
                'email.email'   => 'El correo electrónico no es válido.',
                'email.max'     => 'El correo no puede superar 150 caracteres.',
                'description.max' => 'La descripción no puede superar 2000 caracteres.',
            ]);

            $insurance = Insurance::create([
                'name'          => $request->name,
                'provider'      => $request->provider,
                'policy_number' => $request->policy_number,
                'coverage_type' => $request->coverage_type,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'status'        => $request->boolean('status', true),
                'description'   => $request->description,
            ]);

            return redirect()->route('admin.insurances.index')
                ->with('swal', [
                    'title' => '¡Creado!',
                    'text'  => 'Seguro registrado correctamente.',
                    'icon'  => 'success',
                ]);

        } catch (ValidationException $e) {
            throw $e;
        } catch (QueryException $e) {
            return redirect()->back()->withInput()
                ->with('swal', [
                    'title' => 'Error de base de datos',
                    'text'  => 'No se pudo guardar el seguro. Intenta de nuevo.',
                    'icon'  => 'error',
                ]);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()
                ->with('swal', [
                    'title' => 'Error inesperado',
                    'text'  => 'Ocurrió un problema al registrar el seguro.',
                    'icon'  => 'error',
                ]);
        }
    }

    public function show(Insurance $insurance)
    {
        return view('layouts.includes.admin.insurances.edit', compact('insurance'));
    }

    public function edit(Insurance $insurance)
    {
        return view('layouts.includes.admin.insurances.edit', compact('insurance'));
    }

    public function update(Request $request, Insurance $insurance)
    {
        try {
            $request->validate([
                'name'           => ['required', 'string', 'min:2', 'max:150'],
                'provider'       => ['nullable', 'string', 'min:2', 'max:150'],
                'policy_number'  => ['nullable', 'string', 'max:100', Rule::unique('insurances', 'policy_number')->ignore($insurance->id)],
                'coverage_type'  => ['nullable', 'string', 'max:100'],
                'phone'          => ['nullable', 'string', 'min:10', 'max:10', 'regex:/^[0-9]+$/'],
                'email'          => ['nullable', 'email', 'max:150'],
                'status'         => ['boolean'],
                'description'    => ['nullable', 'string', 'max:2000'],
            ], [
                'name.required' => 'El nombre del seguro es obligatorio.',
                'name.min'      => 'El nombre debe tener al menos 2 caracteres.',
                'name.max'      => 'El nombre no puede superar 150 caracteres.',
                'provider.min'  => 'El proveedor debe tener al menos 2 caracteres.',
                'provider.max'  => 'El proveedor no puede superar 150 caracteres.',
                'policy_number.max' => 'El número de póliza no puede superar 100 caracteres.',
                'policy_number.unique' => 'Este número de póliza ya está registrado.',
                'coverage_type.max' => 'El tipo de cobertura no puede superar 100 caracteres.',
                'phone.min'     => 'El teléfono debe tener al menos 10 caracteres.',
                'phone.max'     => 'El teléfono no puede superar 10 caracteres.',
                'phone.regex'   => 'El teléfono solo puede contener números.',
                'email.email'   => 'El correo electrónico no es válido.',
                'email.max'     => 'El correo no puede superar 150 caracteres.',
                'description.max' => 'La descripción no puede superar 2000 caracteres.',
            ]);

            $insurance->update([
                'name'          => $request->name,
                'provider'      => $request->provider,
                'policy_number' => $request->policy_number,
                'coverage_type' => $request->coverage_type,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'status'        => $request->boolean('status', true),
                'description'   => $request->description,
            ]);

            return redirect()->route('admin.insurances.index')
                ->with('swal', [
                    'title' => '¡Guardado!',
                    'text'  => 'Seguro actualizado correctamente.',
                    'icon'  => 'success',
                ]);

        } catch (ValidationException $e) {
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
                    'text'  => 'Ocurrió un problema al actualizar el seguro.',
                    'icon'  => 'error',
                ]);
        }
    }

    public function destroy(Insurance $insurance)
    {
        try {
            $insurance->delete();

            return redirect()->route('admin.insurances.index')
                ->with('swal', [
                    'title' => '¡Eliminado!',
                    'text'  => 'Seguro eliminado correctamente.',
                    'icon'  => 'success',
                ]);

        } catch (QueryException $e) {
            return redirect()->back()
                ->with('swal', [
                    'title' => 'Error al eliminar',
                    'text'  => 'No se pudo eliminar el seguro. Puede tener registros relacionados.',
                    'icon'  => 'error',
                ]);
        } catch (Throwable $e) {
            return redirect()->back()
                ->with('swal', [
                    'title' => 'Error inesperado',
                    'text'  => 'Ocurrió un problema al eliminar el seguro.',
                    'icon'  => 'error',
                ]);
        }
    }
}
