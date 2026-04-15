<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra el listado de usuarios con paginación.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('layouts.includes.admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Role::all();
        return view('layouts.includes.admin.users.create', compact('roles'));
    }

    /**
     * Almacena el usuario en la base de datos (PostgreSQL).
     */
    public function store(Request $request)
{
    // 1. Filtrado y Validación estricta
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'id_number' => 'required|unique:users,id_number',
        'role' => 'required|exists:roles,name', // Validación de Spatie
    ]);

    // 2. Creación con Encriptación
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']), // Encriptación Bcrypt
        'id_number' => $request->id_number,
        'phone' => $request->phone,
        'address' => $request->address,
    ]);

    // 3. Asignación de Roles vía Spatie
    $user->assignRole($request->role);

    return redirect()->route('admin.users.index')->with('swal', 'Creado');
}

    /**
     * Muestra el formulario de edición.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('layouts.includes.admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza la información del usuario.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'id_number' => 'required|string|unique:users,id_number,' . $user->id,
            'role'      => 'required|exists:roles,name',
        ]);

        // Actualización de datos básicos
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'id_number' => $request->id_number,
            'phone'     => $request->phone,
            'address'   => $request->address,
        ]);

        // Si el usuario ingresó una nueva contraseña, se cifra y actualiza
        if ($request->filled('password')) {
            $request->validate(['password' => 'confirmed|min:8']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Sincronización de roles
        $user->syncRoles([$request->role]);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Usuario actualizado',
            'text'  => 'Los cambios se han guardado correctamente.',
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Elimina al usuario (Soft Delete) con validación de seguridad.
     */
   public function destroy(User $user)
{
    // REGLA 1: No eliminarse a sí mismo
    if ($user->id === auth()->id()) {
        return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta.');
    }

    // REGLA 2: No eliminar al Super Admin (asumiendo que tiene ID 1 o un rol específico)
    if ($user->hasRole('admin')) {
        return redirect()->back()->with('error', 'El Super Administrador no puede ser removido.');
    }

    $user->delete();
    return redirect()->route('admin.users.index')->with('swal', 'Eliminado');
}
}
