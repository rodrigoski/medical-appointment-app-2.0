<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;

Route::redirect('/', '/admin');

// Rutas protegidas por autenticación (Jetstream/Fortify)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard General
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- GRUPO ADMINISTRATIVO ---
    // Este grupo añade el prefijo /admin a la URL y "admin." al nombre de la ruta
    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard del Administrador
            Route::get('/', function () {
                return view('admin.dashboard'); // Asegúrate que esta vista exista
            })->name('dashboard');

            // CRUD de Usuarios (Esto repara el error admin.users.index)
            Route::resource('users', UserController::class);

            // CRUD de Roles
            Route::resource('roles', RoleController::class);
        });
});
