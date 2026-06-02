<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web', 'auth')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Modelo no encontrado
        $exceptions->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Recurso no encontrado.'], 404);
            }
            return redirect()->back()->with('swal', [
                'title' => 'No encontrado',
                'text'  => 'El registro que buscas no existe o fue eliminado.',
                'icon'  => 'error',
            ]);
        });

        // Ruta no encontrada
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Ruta no encontrada.'], 404);
            }
            return response()->view('errors.404', [], 404);
        });

        // Error de base de datos
        $exceptions->renderable(function (QueryException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Error de base de datos.'], 500);
            }
            return redirect()->back()->withInput()->with('swal', [
                'title' => 'Error de base de datos',
                'text'  => 'No se pudieron guardar los cambios. Intenta de nuevo.',
                'icon'  => 'error',
            ]);
        });

        // Cualquier otro error inesperado
        $exceptions->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Error interno del servidor.',
                    'error'   => config('app.debug') ? $e->getMessage() : null,
                ], 500);
            }
        });

    })
    ->create();
