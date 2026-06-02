<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listado de usuarios.
     */
    public function index(): View
    {
        $users = User::paginate(10);
        return view('layouts.includes.admin.users.index', compact('users'));
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        $roles = Role::all();
        return view('layouts.includes.admin.users.create', compact('roles'));
    }

    /**
     * Guardar usuario.
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'name'       => 'required|string|max:255',
        'email'      => 'required|string|email|unique:users,email',
        'password'   => 'required|string|min:8|confirmed',
        'id_number'  => 'required|string|unique:users,id_number',
        'phone'      => 'nullable|string|max:20',
        'address'    => 'nullable|string|max:255',
        'role'       => 'required|exists:roles,name',
    ]);

    $user = User::create([
        'name'       => $validated['name'],
        'email'      => $validated['email'],
        'password'   => Hash::make($validated['password']),
        'id_number'  => $validated['id_number'],
        'phone'      => $validated['phone'] ?? null,
        'address'    => $validated['address'] ?? null,
    ]);

    $user->assignRole($validated['role']);

    if ($user->hasRole('Paciente')) {
        $patient = $user->patient()->create([]);
        return redirect()->route('admin.patients.edit', $patient);
    }

    if ($user->hasRole('Doctor')) {
        $doctor = $user->doctor()->create([
            'name' => $validated['name'],
        ]);
        return redirect()->route('admin.doctors.edit', $doctor);
    }

    return redirect()
        ->route('admin.users.index')
        ->with('swal', 'Creado');
}

    /**
     * Formulario de edición.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('layouts.includes.admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'id_number'  => 'required|string|unique:users,id_number,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:255',
            'password'   => 'nullable|string|min:8|confirmed',
            'role'       => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'id_number' => $validated['id_number'],
            'phone'     => $validated['phone'] ?? null,
            'address'   => $validated['address'] ?? null,
        ]);

        // Actualizar contraseña solo si viene
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Sincronizar rol
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('swal', [
                'icon'  => 'success',
                'title' => 'Usuario actualizado',
                'text'  => 'Los cambios se han guardado correctamente.',
            ]);
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user): RedirectResponse
    {
        // No eliminarse a sí mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        // Evitar eliminar admin (mejor usar permiso real en vez de string)
        if ($user->hasRole('admin')) {
            return back()->with('error', 'El administrador no puede ser eliminado.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('swal', 'Eliminado');
    }
}
