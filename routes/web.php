<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificadosController;
use App\Http\Controllers\ReclamacionesController;

$adminDomain = config('app.admin_domain', 'admin.gisemin.com');

$publicDomains = [
    config('app.public_domain', 'gisemin.com'),
    'www.gisemin.com',
];

/*
|--------------------------------------------------------------------------
| Rutas Publicas (solo dominio principal)
|--------------------------------------------------------------------------
*/

foreach ($publicDomains as $domain) {
    Route::domain($domain)->group(function () {
    // Pagina principal - Landing
    Route::get('/', function () {
        $totalCursos = \DB::table('cursos')->count();
        return view('landing', ['totalCursos' => $totalCursos]);
    })->name('home');

    // Verificar certificados - Pagina publica
    Route::get('/certificados', function () {
        return view('public.certificados');
    })->name('certificados');

    // Formulario de contacto
    Route::post('/contact', function () {
        // TODO: Implementar logica de envio de correo
        return back()->with('success', 'Mensaje enviado correctamente');
    })->name('contact.send');

    // Libro de Reclamaciones
    Route::get('/libro-reclamaciones', function () {
        return view('public.libro-reclamaciones');
    })->name('libro-reclamaciones');

    Route::post('/libro-reclamaciones', [ReclamacionesController::class, 'store'])->name('libro-reclamaciones.store');

    /*
    |--------------------------------------------------------------------------
    | API Routes (Publicas)
    |--------------------------------------------------------------------------
    */

    Route::prefix('api')->group(function () {
        // Busqueda publica de certificados
        Route::get('/certificados/buscar', [CertificadosController::class, 'buscar']);
        Route::get('/certificados/recientes', [CertificadosController::class, 'obtenerRecientes']);

        // Cursos para autocompletado
        Route::get('/cursos', [CertificadosController::class, 'obtenerCursos']);
        Route::post('/cursos', [CertificadosController::class, 'guardarCurso']);
    });
    });
}

/*
|--------------------------------------------------------------------------
| Rutas Admin (Panel de Administracion)
|--------------------------------------------------------------------------
*/

Route::domain($adminDomain)->name('admin.')->group(function () {
    // Login - Acceso al panel
    Route::get('/login', function () {
        return view('admin.login');
    })->name('login');

    // Procesar login
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth.simple', 'is_admin']);

    // Rutas protegidas - Requieren autenticacion y rol admin
    Route::middleware(['auth.simple', 'is_admin'])->group(function () {
        // Dashboard principal
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::redirect('/dashboard', '/', 302);

        // Gestion de certificados
        Route::get('/certificados/agregar', [CertificadosController::class, 'create'])->name('certificados.agregar');
        Route::post('/certificados/agregar', [CertificadosController::class, 'store'])->name('certificados.store');
        Route::get('/certificados/gestionar', [CertificadosController::class, 'gestionar'])->name('certificados.gestionar');
        Route::get('/certificados/lista', [CertificadosController::class, 'listarVista'])->name('certificados.lista');

        // Gestion de Reclamaciones
        Route::get('/reclamaciones', [ReclamacionesController::class, 'index'])->name('reclamaciones.index');
        Route::get('/reclamaciones/{id}', [ReclamacionesController::class, 'show'])->name('reclamaciones.show');

        // API para gestion de certificados
        Route::prefix('api')->group(function () {
            Route::get('/certificados/todos', [CertificadosController::class, 'obtenerTodos']);
            Route::get('/certificados/usuarios', [CertificadosController::class, 'obtenerUsuariosCertificado']);

            // Rutas especificas primero (antes de {id})
            Route::put('/certificados/actualizar', [CertificadosController::class, 'actualizarCertificado']);
            Route::delete('/certificados/eliminar', [CertificadosController::class, 'eliminarCertificado']);
            Route::post('/certificados/categorizar', [CertificadosController::class, 'categorizarCurso']);
            Route::post('/certificados/crear-curso', [CertificadosController::class, 'crearCurso']);

            // Rutas con ID al final
            Route::get('/certificados/{id}', [CertificadosController::class, 'show']);
            Route::put('/certificados/{id}', [CertificadosController::class, 'update']);
            Route::delete('/certificados/{id}', [CertificadosController::class, 'destroy']);

            // Rutas de trabajadores y empresas
            Route::get('/trabajadores/buscar', [CertificadosController::class, 'buscarTrabajador']);
            Route::post('/trabajadores/registrar', [CertificadosController::class, 'registrarTrabajador']);
            Route::put('/trabajadores/actualizar', [CertificadosController::class, 'actualizarTrabajador']);
            Route::put('/empresas/actualizar', [CertificadosController::class, 'actualizarEmpresaMasivo']);
            Route::post('/trabajadores/asignar-empresa', [CertificadosController::class, 'asignarEmpresa']);
            Route::post('/trabajadores/remover-empresa', [CertificadosController::class, 'removerEmpresa']);
            Route::get('/empresas/buscar', [CertificadosController::class, 'buscarEmpresas']);
            Route::delete('/trabajadores/{dni}', [CertificadosController::class, 'eliminarTrabajador']);

            // API para reclamaciones
            Route::get('/cursos/buscar', [CertificadosController::class, 'buscarCursos']);
            Route::get('/certificados/check-status', [CertificadosController::class, 'checkStatus']);

            Route::put('/reclamaciones/{id}/status', [ReclamacionesController::class, 'updateStatus']);
            Route::delete('/reclamaciones/{id}', [ReclamacionesController::class, 'destroy']);
        });
    });
});
