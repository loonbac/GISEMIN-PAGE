<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificadosController;
use App\Http\Controllers\ReclamacionesController;

$adminDomain = config('app.admin_domain', 'admin.gisemin.com');
$publicDomain = config('app.public_domain', 'gisemin.com');

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Página principal - Landing
Route::get('/', function () {
    $totalCursos = \DB::table('cursos')->count();
    return view('landing', ['totalCursos' => $totalCursos]);
})->name('home');

// Verificar certificados - Página pública
Route::get('/certificados', function () {
    return view('public.certificados');
})->name('certificados');

// Formulario de contacto
Route::post('/contact', function () {
    // TODO: Implementar lógica de envío de correo
    return back()->with('success', 'Mensaje enviado correctamente');
})->name('contact.send');

// Libro de Reclamaciones
Route::get('/libro-reclamaciones', function () {
    return view('public.libro-reclamaciones');
})->name('libro-reclamaciones');

Route::post('/libro-reclamaciones', [ReclamacionesController::class, 'store'])->name('libro-reclamaciones.store');

/*
|--------------------------------------------------------------------------
| API Routes (Públicas)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    // Búsqueda pública de certificados
    Route::get('/certificados/buscar', [CertificadosController::class, 'buscar']);
    Route::get('/certificados/recientes', [CertificadosController::class, 'obtenerRecientes']);
    
    // Cursos para autocompletado
    Route::get('/cursos', [CertificadosController::class, 'obtenerCursos']);
    Route::post('/cursos', [CertificadosController::class, 'guardarCurso']);
});

/*
|--------------------------------------------------------------------------
| Rutas Admin (Panel de Administración)
|--------------------------------------------------------------------------
*/

Route::domain($adminDomain)->name('admin.')->group(function () {
    // Login - Acceso al panel
    Route::get('/login', function () {
        return view('admin.login');
    /*
    |
    |
    |
    |
    | Rutas Públicas (solo dominio principal)
    |
    |
    |
    |
    */

    Route::domain($publicDomain)->group(function () {
        // Página principal - Landing
        Route::get('/', function () {
            $totalCursos = \DB::table('cursos')->count();
            return view('landing', ['totalCursos' => $totalCursos]);
        })->name('home');

        // Verificar certificados - Página pública
        Route::get('/certificados', function () {
            return view('public.certificados');
        })->name('certificados');

        // Formulario de contacto
        Route::post('/contact', function () {
            // TODO: Implementar lógica de envío de correo
            return back()->with('success', 'Mensaje enviado correctamente');
        })->name('contact.send');

        // Libro de Reclamaciones
        Route::get('/libro-reclamaciones', function () {
            return view('public.libro-reclamaciones');
        })->name('libro-reclamaciones');

        Route::post('/libro-reclamaciones', [ReclamacionesController::class, 'store'])->name('libro-reclamaciones.store');

        /*
        |
        |
        |
        |
        | API Routes (Públicas)
        |
        |
        |
        |
        */

        Route::prefix('api')->group(function () {
            // Búsqueda pública de certificados
            Route::get('/certificados/buscar', [CertificadosController::class, 'buscar']);
            Route::get('/certificados/recientes', [CertificadosController::class, 'obtenerRecientes']);

            // Cursos para autocompletado
            Route::get('/cursos', [CertificadosController::class, 'obtenerCursos']);
            Route::post('/cursos', [CertificadosController::class, 'guardarCurso']);
        });
    });
