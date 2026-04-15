<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // Lista de roles protegidos (Regla de negocio 30 pts)
    protected $protectedRoles = ['Admin', 'Doctor', 'Paciente', 'Recepcionista', 'Superadmin'];

    public function index()
    {
        $roles = Role::all();
        return view('layouts.includes.admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('layouts.includes.admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name'
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->route('admin.roles.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Rol creado correctamente'
        ]);
    }

    public function edit(Role $role)
    {
        if (in_array($role->name, $this->protectedRoles)) {
            return redirect()->route('admin.roles.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Acceso Denegado',
                'text' => 'Los roles del sistema no pueden editarse.'
            ]);
        }

        return view('layouts.includes.admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        return redirect()->route('admin.roles.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Actualizado',
            'text' => 'Rol actualizado correctamente'
        ]);
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, $this->protectedRoles)) {
            return redirect()->route('admin.roles.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Operación Prohibida',
                'text' => 'No puedes eliminar roles críticos de Healthify.'
            ]);
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Eliminado',
            'text' => 'El rol ha sido removido.'
        ]);
    }
}
