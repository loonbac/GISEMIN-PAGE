<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Trabajador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificadosController extends Controller
{
    /**
     * Mostrar formulario para agregar certificado
     */
    public function create()
    {
        return view('admin.certificados.agregar');
    }

    /**
     * Buscar trabajador por DNI
     * Retorna información del trabajador si existe
     */
    public function buscarTrabajador(Request $request)
    {
        $dni = $request->get('dni', '');
        
        if (strlen($dni) < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Ingresa un DNI para buscar',
            ]);
        }

        // Buscar en tabla trabajadores
        $trabajador = Trabajador::where('dni', $dni)->first();
        
        if (!$trabajador) {
            // Fallback: buscar en certificados por si acaso (migración de datos antigua)
            $cert = Certificado::where('dni', $dni)->first();
            if ($cert) {
                // Crear trabajador automáticamente si existe en certificados pero no en trabajadores
                $trabajador = Trabajador::create([
                    'nombre' => $cert->nombre,
                    'dni' => $cert->dni,
                ]);
            }
        }
        
        if (!$trabajador) {
            return response()->json([
                'success' => false,
                'encontrado' => false,
                'message' => 'Trabajador no registrado',
            ]);
        }

        // Contar certificados del trabajador y separar por estado
        // AUTO-LIMPIEZA: Si tiene uno vigente para un curso, eliminar los vencidos de ese mismo curso
        $allCerts = Certificado::where('dni', $dni)->orderBy('fecha_vencimiento', 'desc')->get();
        $now = now()->setTimezone('America/Lima')->format('Y-m-d');
        
        // Identificar cursos que ya tienen vigente
        $cursosVigentes = $allCerts->filter(function($c) use ($now) {
            $fVal = is_object($c->fecha_vencimiento) ? $c->fecha_vencimiento->format('Y-m-d') : substr((string)$c->fecha_vencimiento, 0, 10);
            return $fVal >= $now;
        })->pluck('curso')->unique();

        // Eliminar vencidos que coincidan con cursos vigentes
        if ($cursosVigentes->isNotEmpty()) {
            Certificado::where('dni', $dni)
                ->whereIn('curso', $cursosVigentes)
                ->where('fecha_vencimiento', '<', $now)
                ->delete();
            
            // Recargar certificados limpios
            $allCerts = Certificado::where('dni', $dni)->orderBy('fecha_vencimiento', 'desc')->get();
        }

        $today = date('Y-m-d');
        
        $vigentes = $allCerts->filter(function($c) use ($today) {
            if (empty($c->fecha_vencimiento)) return false;
            
            // Obtener string Y-m-d seguro
            $fVal = $c->fecha_vencimiento;
            if (is_object($fVal) && method_exists($fVal, 'format')) {
                $fVal = $fVal->format('Y-m-d');
            } else {
                $fVal = substr((string)$fVal, 0, 10);
            }
            
            return $fVal >= $today;
        })->values();

        $vencidos = $allCerts->filter(function($c) use ($today) {
            if (empty($c->fecha_vencimiento)) return false;
            
            $fVal = $c->fecha_vencimiento;
            if (is_object($fVal) && method_exists($fVal, 'format')) {
                $fVal = $fVal->format('Y-m-d');
            } else {
                $fVal = substr((string)$fVal, 0, 10);
            }
            
            return $fVal < $today;
        })->values();

        return response()->json([
            'success' => true,
            'encontrado' => true,
            'trabajador' => [
                'nombre' => $trabajador->nombre,
                'dni' => $trabajador->dni,
                'empresa' => $trabajador->empresa,
                'total_certificados' => $allCerts->count(),
                'vigentes' => $vigentes,
                'vencidos' => $vencidos
            ],
        ]);
    }

    /**
     * Obtener lista de empresas únicas para el autocompletado
     */
    public function buscarEmpresas(Request $request)
    {
        $query = $request->get('q', '');
        
        $empresas = Trabajador::whereNotNull('empresa')
            ->where('empresa', '!=', 'Independiente')
            ->where('empresa', 'LIKE', "%{$query}%")
            ->distinct()
            ->pluck('empresa')
            ->take(10);
            
        return response()->json($empresas);
    }

    public function registrarTrabajador(Request $request)
    {
        \Log::info('Intento de registro de trabajador', $request->all());
        
        try {
            $validated = $request->validate([
                'nombre' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.-]+$/'],
                'dni' => 'required|numeric|digits_between:1,20|unique:trabajadores,dni',
            ]);

            $trabajador = Trabajador::create([
                'nombre' => strtoupper($validated['nombre']),
                'dni' => $validated['dni'],
                'empresa' => null, // Siempre inicia como independiente
            ]);

            \Log::info('Trabajador registrado con éxito', ['id' => $trabajador->id]);

            return response()->json([
                'success' => true,
                'trabajador' => [
                    'nombre' => $trabajador->nombre,
                    'dni' => $trabajador->dni,
                    'empresa' => $trabajador->empresa,
                    'total_certificados' => 0,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Error validación registro trabajador', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error registrando trabajador: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Guardar certificado en la base de datos
     */
    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\.-]+$/'],
            'dni' => 'required|numeric|digits_between:1,20',
            'curso' => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'duracion' => 'required|integer|min:1|max:12', // Validar meses
            'drive_link' => 'nullable|url|max:2048',
            'empresa' => 'nullable|string|max:255',
        ]);

        // Obtener el curso (debe existir previamente)
        $curso = Curso::where('nombre', $validated['curso'])
                      ->whereNotNull('categoria')
                      ->where('categoria', '!=', '')
                      ->first();

        if (!$curso) {
            $msg = '❌ El curso no existe en el sistema. Debes crearlo primero en "Gestionar Cursos".';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg
                ], 404);
            }
            return back()->withInput()->with('error', $msg);
        }

        // Incrementar uso
        $curso->increment('uso_count');


        // Asegurar que existe el trabajador
        $trabajador = Trabajador::firstOrCreate(
            ['dni' => $request->dni],
            ['nombre' => $request->nombre]
        );

        // Si el nombre cambió, actualizarlo
        if ($trabajador->nombre !== $request->nombre) {
            $trabajador->update(['nombre' => strtoupper($request->nombre)]);
        }

        // Lógica de Empresa: Solo permitir asignar si el trabajador es actualmente independiente
        if (empty($trabajador->empresa) && !empty($request->empresa)) {
            $trabajador->update(['empresa' => strtoupper($request->empresa)]);
        }

        // Calcular fecha de vencimiento basado en duración (meses)
        $fechaEmision = Carbon::parse($request->fecha_emision);
        $fechaVencimiento = $fechaEmision->copy()->addMonths((int) $request->duracion);

        // ---------------------------------------------------------
        // VALIDACIÓN Y LÓGICA DE NEGOCIO (DUPLICADOS Y RENOVACIÓN)
        // ---------------------------------------------------------
        $hoy = now()->setTimezone('America/Lima')->format('Y-m-d');

        // 1. Verificar si ya tiene uno VIGENTE (No permitir duplicados)
        $dniForm = trim($request->dni);
        $cursoNombreForm = trim($curso->nombre);

        $vigente = Certificado::where('dni', $dniForm)
            ->whereRaw('LOWER(curso) = ?', [strtolower($cursoNombreForm)])
            ->where('fecha_vencimiento', '>=', $hoy)
            ->first();

        if ($vigente) {
            $msg = '⚠️ El trabajador ya cuenta con un certificado VIGENTE para el curso "' . $curso->nombre . '".';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg
                ], 422);
            }
            return back()->withInput()->with('error', $msg);
        }

        // 2. Renovación: Eliminar historial VENCIDO automáticamente
        // Si el usuario tenía certificados vencidos de este mismo curso, los borramos para dejar solo el nuevo.
        Certificado::where('dni', $request->dni)
            ->where('curso', $curso->nombre)
            ->where('fecha_vencimiento', '<', $hoy)
            ->delete();
        // ---------------------------------------------------------

        // Generar código autogenerado único
        $codigo = 'CERT-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));

        // Crear certificado
        Certificado::create([
            'nombre' => $request->nombre,
            'dni' => $request->dni,
            'curso' => $curso->nombre,
            'fecha_emision' => $fechaEmision,
            'codigo' => $codigo,
            'fecha_vencimiento' => $fechaVencimiento,
            'estado' => $fechaVencimiento->isPast() ? 'expirado' : 'vigente',
            'drive_link' => $request->drive_link ?? null,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '✅ Certificado registrado correctamente.',
                'codigo' => $codigo,
                'dni' => $request->dni
            ]);
        }

        return redirect()->route('admin.certificados.agregar')
                       ->with('success', '✅ Certificado registrado correctamente. Código generado: ' . $codigo);
    }

    /**
     * Buscar certificados públicamente
     */
    /**
     * Buscar certificados públicamente
     */
    public function buscar(Request $request)
    {
        $termino = $request->get('q', '');
        
        if (strlen($termino) < 2) {
            return response()->json([]);
        }

        // Buscar SOLO por DNI exacto (como pidió el usuario) y solo certificados VIGENTES
        // DNI diferente = Usuario diferente.
        $certificados = Certificado::with('trabajador')->vigentes()
            ->where('dni', $termino)
            ->get();

        if ($certificados->isEmpty()) {
            return response()->json([]); // Retornar vacío si no hay vigentes
        }

        // Obtener categorías para el display
        $cursos = Curso::whereIn('nombre', $certificados->pluck('curso')->unique())->get()->keyBy('nombre');

        $resultados = [];

        foreach ($certificados as $cert) {
            $curso = $cursos->get($cert->curso);
            
            $resultados[] = [
                'nombre' => $cert->nombre,
                'dni' => $cert->dni,
                'empresa' => $cert->trabajador ? $cert->trabajador->empresa : 'INDEPENDIENTE',
                'curso' => $cert->curso,
                'categoria' => ($curso && $curso->categoria) ? $curso->categoria : 'General',
                'fecha' => $cert->fecha_emision->format('d/m/Y'),
                'codigo' => $cert->codigo,
                'drive_link' => $cert->drive_link,
                'estado' => $cert->estado ?? 'vigente',
            ];
        }

        return response()->json($resultados);
    }

    /**
     * Mostrar vista de lista de todos los certificados/usuarios
     */
    public function listarVista()
    {
        $now = now()->setTimezone('America/Lima')->format('Y-m-d');

        // Obtener todos los trabajadores con sus certificados
        $trabajadores = Trabajador::with(['certificados' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->orderBy('nombre', 'asc')->get();

        // Formatear para la vista
        $usuarios = $trabajadores->map(function($user) use ($now) {
            $certs = $user->certificados;
            $vigentes = $certs->filter(fn($c) => $c->fecha_vencimiento >= $now);
            $expirados = $certs->filter(fn($c) => $c->fecha_vencimiento < $now);
            
            return [
                'nombre' => $user->nombre,
                'dni' => $user->dni,
                'empresa' => $user->empresa,
                'total_certificados' => $certs->count(),
                'vigentes_count' => $vigentes->count(),
                'expirados_count' => $expirados->count(),
                'certificados' => $certs,
            ];
        });

        $cursos = Curso::orderBy('nombre')->get();
        
        // Agrupar por empresa
        $usuariosPorEmpresa = $usuarios->groupBy(function($u) {
            return strtoupper($u['empresa'] ?: 'Independiente');
        })->sortKeys();

        // Asegurar que INDEPENDIENTE esté al final
        if ($usuariosPorEmpresa->has('INDEPENDIENTE')) {
            $independientes = $usuariosPorEmpresa->pull('INDEPENDIENTE');
            $usuariosPorEmpresa->put('INDEPENDIENTE', $independientes);
        }

        return view('admin.certificados.lista', [
            'usuariosPorEmpresa' => $usuariosPorEmpresa,
            'cursos' => $cursos
        ]);
    }

    /**
     * Obtener todos los certificados (para lista admin - API Legacy)
     */
    public function obtenerTodos()
    {
        $certificados = Certificado::orderBy('created_at', 'desc')->get();

        $resultados = $certificados->map(function($cert) {
            return [
                'nombre' => $cert->nombre,
                'dni' => $cert->dni,
                'curso' => $cert->curso,
                'fecha' => $cert->fecha_emision->format('d/m/Y'),
                'codigo' => $cert->codigo,
                'drive_link' => $cert->drive_link,
                'estado' => $cert->estado ?? 'vigente',
            ];
        });

        return response()->json($resultados);
    }

    /**
     * Obtener certificados recientes (últimos 12)
     */
    public function obtenerRecientes()
    {
        $certificados = Certificado::orderBy('created_at', 'desc')
            ->limit(12)
            ->get();


        $resultados = $certificados->map(function($cert) {
            return [
                'nombre' => $cert->nombre,
                'curso' => $cert->curso,
                'fecha' => $cert->fecha_emision->format('d/m/Y'),
                'codigo' => $cert->codigo,
                'drive_link' => $cert->drive_link,
                'estado' => $cert->estado ?? 'vigente',
            ];
        });

        return response()->json($resultados);
    }

    /**
     * Obtener cursos para autocompletado
     */
    public function obtenerCursos(Request $request)
    {
        $termino = $request->get('q', '');
        
        $cursos = Curso::query();
        
        if ($termino) {
            $cursos->where('nombre', 'like', "%{$termino}%");
        }
        
        $cursos = $cursos->orderBy('uso_count', 'desc')
                         ->orderBy('nombre', 'asc')
                         ->limit(20)
                         ->get(['id', 'nombre']);
        
        return response()->json([
            'success' => true,
            'cursos' => $cursos,
        ]);
    }

    /**
     * Crear nuevo curso desde el panel admin
     */
    public function crearCurso(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|in:obligatorias,alto_riesgo,emergencias,equipos,salud,ambiente,cultura,sectores',
        ]);

        $nombre = trim($validated['nombre']);
        $curso = Curso::where('nombre', $nombre)->first();

        if ($curso) {
            // Si ya existe, actualizamos la categoría
            $curso->update(['categoria' => $validated['categoria']]);
            $mensaje = 'El curso ya existía. Se ha actualizado su categoría.';
        } else {
            // Crear nuevo
            $curso = Curso::create([
                'nombre' => $nombre,
                'categoria' => $validated['categoria'],
                'uso_count' => 0
            ]);
            $mensaje = 'Curso creado correctamente.';
        }

        return response()->json([
            'success' => true,
            'curso' => $curso,
            'message' => $mensaje,
        ]);
    }

    /**
     * Guardar nuevo curso (cuando el usuario escribe uno que no existe en el form público)
     */
    public function guardarCurso(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $curso = Curso::obtenerOCrear($validated['nombre']);

        return response()->json([
            'success' => true,
            'curso' => $curso,
            'message' => 'Curso guardado correctamente',
        ]);
    }

    /**
     * Listar todos los certificados para gestión
     */
    public function gestionar()
    {
        // Obtener todos los cursos agrupados por categoría
        $todosCursos = Curso::orderBy('categoria')->orderBy('nombre', 'asc')->get();

        // Contar cuántos certificados hay para cada curso
        $certificadosPorCurso = Certificado::query()
            ->selectRaw('curso, COUNT(*) as cantidad')
            ->groupBy('curso')
            ->get()
            ->keyBy('curso')
            ->toArray();

        // Agrupar cursos por categoría
        $categorias = [
            'obligatorias' => ['nombre' => '🔴 Capacitaciones Obligatorias / Normativas (SST)', 'cursos' => []],
            'alto_riesgo' => ['nombre' => '🟠 Trabajos de Alto Riesgo (TAR)', 'cursos' => []],
            'emergencias' => ['nombre' => '🟡 Emergencias y Primeros Auxilios', 'cursos' => []],
            'equipos' => ['nombre' => '🔵 Equipos, Maquinaria y Herramientas', 'cursos' => []],
            'salud' => ['nombre' => '🟢 Higiene Ocupacional y Salud', 'cursos' => []],
            'ambiente' => ['nombre' => '🟣 Medio Ambiente y SST (SSOMA)', 'cursos' => []],
            'cultura' => ['nombre' => '⚫ Capacitaciones Complementarias / Cultura Preventiva', 'cursos' => []],
            'sectores' => ['nombre' => '🔧 Capacitaciones Específicas (Según Sector)', 'cursos' => []],
        ];

        foreach ($todosCursos as $curso) {
            $categoria = $curso->categoria;
            if ($categoria && isset($categorias[$categoria])) {
                $categorias[$categoria]['cursos'][] = [
                    'nombre' => $curso->nombre,
                    'cantidad' => $certificadosPorCurso[$curso->nombre]['cantidad'] ?? 0,
                    'id' => $curso->id,
                ];
            }
        }

        return view('admin.certificados.gestionar', [
            'categorias' => $categorias,
        ]);
    }

    /**
     * Obtener todos los usuarios que tienen un certificado específico
     */
    public function obtenerUsuariosCertificado(Request $request)
    {
        $curso = $request->get('curso', '');

        if (!$curso) {
            return response()->json([
                'success' => false,
                'message' => 'Curso no especificado',
            ]);
        }

        $usuarios = Certificado::where('curso', $curso)
            ->select('id', 'nombre', 'dni', 'fecha_emision', 'codigo')
            ->get();

        return response()->json([
            'success' => true,
            'usuarios' => $usuarios,
            'total' => $usuarios->count(),
        ]);
    }

    /**
     * Actualizar nombre de un certificado (para todos los usuarios que lo tienen)
     */
    public function actualizarCertificado(Request $request)
    {
        $validated = $request->validate([
            'curso_actual' => 'required|string|max:255',
            'curso_nuevo' => 'required|string|max:255',
        ]);

        $cursoActual = $validated['curso_actual'];
        $cursoNuevo = $validated['curso_nuevo'];

        // Actualizar todos los certificados con el nombre anterior
        $cantidad = Certificado::where('curso', $cursoActual)
            ->update(['curso' => $cursoNuevo]);

        // Si existe un curso en la tabla de cursos, actualizarlo también
        $cursoModel = Curso::where('nombre', $cursoActual)->first();
        if ($cursoModel) {
            $cursoModel->update(['nombre' => $cursoNuevo]);
        }

        return response()->json([
            'success' => true,
            'message' => "Se actualizaron $cantidad certificados",
        ]);
    }

    /**
     * Eliminar un certificado y todos sus registros de usuarios
     */
    public function eliminarCertificado(Request $request)
    {
        $validated = $request->validate([
            'curso' => 'required|string|max:255',
        ]);

        $curso = $validated['curso'];

        // Contar cuántos se van a eliminar
        $cantidad = Certificado::where('curso', $curso)->count();

        // Obtener la categoría del curso antes de eliminarlo
        $cursoModel = \App\Models\Curso::where('nombre', $curso)->first();
        $categoria = ($cursoModel && $cursoModel->categoria) ? $cursoModel->categoria : 'sin categoría';

        // Eliminar todos los certificados con ese nombre
        Certificado::where('curso', $curso)->delete();

        // Si existe un curso en la tabla de cursos, eliminarlo también
        \App\Models\Curso::where('nombre', $curso)->delete();

        $mensaje = "Se eliminó 1 certificado de la categoría '$categoria'";
        
        if ($cantidad > 0) {
            $mensaje .= " y se borraron $cantidad registros de usuarios asociados.";
        } else {
            $mensaje .= ".";
        }

        return response()->json([
            'success' => true,
            'message' => $mensaje,
        ]);
    }

    /**
     * Obtener un certificado específico para editar
     */
    public function show($id)
    {
        $certificado = Certificado::findOrFail($id);
        
        $hoy = now()->setTimezone('America/Lima')->format('Y-m-d');
        
        // Cursos que ya tiene vigentes (excluyendo el actual que estamos editando)
        $cursosVigentes = Certificado::where('dni', $certificado->dni)
            ->where('id', '!=', $id)
            ->where('fecha_vencimiento', '>=', $hoy)
            ->pluck('curso')
            ->map(fn($c) => strtolower($c))
            ->toArray();

        return response()->json([
            'success' => true,
            'certificado' => $certificado,
            'cursos_vigentes' => $cursosVigentes
        ]);
    }

    /**
     * Actualizar un certificado específico (desde lista)
     */
    public function update(Request $request, $id)
    {
        $certificado = Certificado::findOrFail($id);

        $validated = $request->validate([
            'curso' => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'drive_link' => 'nullable|url|max:2048',
        ]);

        // Calcular vencimiento (un año por defecto)
        $fechaEmision = Carbon::parse($validated['fecha_emision']);
        $fechaVencimiento = $fechaEmision->copy()->addYear();

        $hoy = now()->setTimezone('America/Lima')->format('Y-m-d');
        $dni = $certificado->dni;

        // Verificar si ya tiene otro vigente para el mismo curso
        $duplicado = Certificado::where('dni', $dni)
            ->where('id', '!=', $id)
            ->whereRaw('LOWER(curso) = ?', [strtolower($validated['curso'])])
            ->where('fecha_vencimiento', '>=', $hoy)
            ->first();

        if ($duplicado) {
            return response()->json([
                'success' => false,
                'message' => '⚠️ El trabajador ya cuenta con un certificado VIGENTE para el curso "' . $validated['curso'] . '".'
            ], 422);
        }
        
        $certificado->update([
            'curso' => $validated['curso'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vencimiento' => $fechaVencimiento,
            'drive_link' => $validated['drive_link'],
        ]);

        // Obtener estadísticas actualizadas para el UI
        $hoy = now()->setTimezone('America/Lima')->format('Y-m-d');
        $userStats = [
            'total' => Certificado::where('dni', $dni)->count(),
            'vigentes' => Certificado::where('dni', $dni)->where('fecha_vencimiento', '>=', $hoy)->count(),
            'expirados' => Certificado::where('dni', $dni)->where('fecha_vencimiento', '<', $hoy)->count(),
        ];

        $globalStats = [
            'total_usuarios' => \App\Models\Trabajador::count(),
            'total_certificados' => Certificado::count(),
            'total_vigentes' => Certificado::where('fecha_vencimiento', '>=', $hoy)->count(),
            'total_expirados' => Certificado::where('fecha_vencimiento', '<', $hoy)->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Certificado actualizado correctamente',
            'certificado' => $certificado,
            'user_stats' => $userStats,
            'global_stats' => $globalStats,
            'formatted_date' => $fechaEmision->format('d/m/Y'),
            'es_vigente' => $fechaVencimiento->gte($hoy)
        ]);
    }

    /**
     * Eliminar un certificado específico
     */
    public function destroy($id)
    {
        $certificado = Certificado::findOrFail($id);
        $dni = $certificado->dni;
        $certificado->delete();

        $hoy = now()->setTimezone('America/Lima')->format('Y-m-d');
        
        $userStats = [
            'total' => Certificado::where('dni', $dni)->count(),
            'vigentes' => Certificado::where('dni', $dni)->where('fecha_vencimiento', '>=', $hoy)->count(),
            'expirados' => Certificado::where('dni', $dni)->where('fecha_vencimiento', '<', $hoy)->count(),
        ];

        $globalStats = [
            'total_usuarios' => \App\Models\Trabajador::count(),
            'total_certificados' => Certificado::count(),
            'total_vigentes' => Certificado::where('fecha_vencimiento', '>=', $hoy)->count(),
            'total_expirados' => Certificado::where('fecha_vencimiento', '<', $hoy)->count(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Certificado eliminado correctamente',
            'user_stats' => $userStats,
            'global_stats' => $globalStats
        ]);
    }

    /**
     * Categorizar un curso (asignar categoría a curso sin categorizar)
     */
    public function categorizarCurso(Request $request)
    {
        $validated = $request->validate([
            'curso' => 'required|string|max:255',
            'categoria' => 'required|in:obligatorias,alto_riesgo,emergencias,equipos,salud,ambiente,cultura,sectores',
        ]);

        $curso = Curso::where('nombre', $validated['curso'])->first();

        if (!$curso) {
            return response()->json([
                'success' => false,
                'message' => 'Curso no encontrado',
            ]);
        }

        $curso->update(['categoria' => $validated['categoria']]);

        $categoriaNombre = match($validated['categoria']) {
            'obligatorias' => 'Capacitaciones Obligatorias',
            'alto_riesgo' => 'Trabajos de Alto Riesgo',
            'emergencias' => 'Emergencias y Primeros Auxilios',
            'equipos' => 'Equipos y Maquinaria',
            'salud' => 'Higiene Ocupacional y Salud',
            'ambiente' => 'Medio Ambiente',
            'cultura' => 'Cultura Preventiva',
            'sectores' => 'Capacitaciones Específicas',
        };

        return response()->json([
            'success' => true,
            'message' => "Curso categorizado en: {$categoriaNombre}",
        ]);
    }

    /**
     * Buscar cursos para autocompletado
     */
    public function buscarCursos(Request $request)
    {
        $term = $request->get('q', '');
        
        $query = \App\Models\Curso::query();
        
        if (strlen($term) > 0) {
            $query->where('nombre', 'like', "%{$term}%");
        }

        // Filtrar cursos que el trabajador ya tiene vigentes
        $dni = $request->get('dni');
        if ($dni) {
            $hoy = now()->setTimezone('America/Lima')->format('Y-m-d');
            $cursosVigentes = \App\Models\Certificado::where('dni', $dni)
                ->where('fecha_vencimiento', '>=', $hoy)
                ->pluck('curso');
                
            if ($cursosVigentes->isNotEmpty()) {
                $query->whereNotIn('nombre', $cursosVigentes);
            }
        }

        $cursos = $query->orderBy('nombre')
            ->get(['id', 'nombre', 'categoria']);
            
        return response()->json($cursos);
    }

    /**
     * Verificar estado de un certificado para un DNI específico
     */
    public function checkStatus(Request $request)
    {
        $dni = trim($request->get('dni'));
        $curso = trim($request->get('curso'));

        if (!$dni || !$curso) {
            return response()->json(['status' => 'error', 'message' => 'Faltan datos']);
        }

        // Primero buscar si tiene uno vigente
        $now = now()->setTimezone('America/Lima')->format('Y-m-d');
        
        $vigente = Certificado::where('dni', $dni)
            ->whereRaw('LOWER(curso) = ?', [strtolower($curso)])
            ->where('fecha_vencimiento', '>=', $now)
            ->first();

        if ($vigente) {
            return response()->json([
                'status' => 'vigente',
                'certificado' => $vigente
            ]);
        }

        // Si no tiene vigente, buscar el último vencido
        $vencido = Certificado::where('dni', $dni)
            ->where('curso', $curso)
            ->where('fecha_vencimiento', '<', $now)
            ->orderBy('fecha_vencimiento', 'desc')
            ->first();

        if ($vencido) {
            return response()->json([
                'status' => 'vencido',
                'certificado' => $vencido
            ]);
        }

        return response()->json(['status' => 'not_found']);
    }
    // Eliminar un trabajador y todos sus certificados asociados
    public function eliminarTrabajador($dni)
    {
        try {
            \DB::beginTransaction();

            // Eliminar certificados asociados
            Certificado::where('dni', $dni)->delete();

            // Eliminar al trabajador
            Trabajador::where('dni', $dni)->delete();

            \DB::commit();

            $hoy = now()->setTimezone('America/Lima')->format('Y-m-d');
            $globalStats = [
                'total_usuarios' => \App\Models\Trabajador::count(),
                'total_certificados' => Certificado::count(),
                'total_vigentes' => Certificado::where('fecha_vencimiento', '>=', $hoy)->count(),
                'total_expirados' => Certificado::where('fecha_vencimiento', '<', $hoy)->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Usuario y sus certificados eliminados correctamente',
                'global_stats' => $globalStats
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar datos del trabajador (Nombre/Empresa) desde la lista
     */
    public function actualizarTrabajador(Request $request)
    {
        try {
            $validated = $request->validate([
                'dni' => 'required|string|exists:trabajadores,dni',
                'nombre' => 'required|string|max:255',
            ]);

            $trabajador = Trabajador::where('dni', $validated['dni'])->firstOrFail();
            
            $trabajador->update([
                'nombre' => strtoupper($validated['nombre']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Trabajador actualizado correctamente',
                'trabajador' => $trabajador
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar trabajador: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar el nombre de una empresa para todos sus trabajadores asociados
     */
    public function actualizarEmpresaMasivo(Request $request)
    {
        try {
            $validated = $request->validate([
                'empresa_actual' => 'required|string',
                'empresa_nueva' => 'required|string|max:255',
            ]);

            $empresaActual = $validated['empresa_actual'] === 'Independiente' ? null : $validated['empresa_actual'];
            $empresaNueva = strtoupper($validated['empresa_nueva']);

            $count = Trabajador::where('empresa', $empresaActual)
                ->update(['empresa' => $empresaNueva]);

            return response()->json([
                'success' => true,
                'message' => "Se han actualizado $count trabajadores correctamente",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar empresa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Asignar empresa a un trabajador de forma inmediata
     */
    public function asignarEmpresa(Request $request)
    {
        try {
            $validated = $request->validate([
                'dni' => 'required|string|exists:trabajadores,dni',
                'empresa' => 'required|string|max:255',
            ]);

            $trabajador = Trabajador::where('dni', $validated['dni'])->firstOrFail();
            $trabajador->update(['empresa' => strtoupper($validated['empresa'])]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al asignar empresa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Quitar a un trabajador de su empresa (volver a independiente)
     */
    public function removerEmpresa(Request $request)
    {
        try {
            $validated = $request->validate([
                'dni' => 'required|string|exists:trabajadores,dni',
            ]);

            $trabajador = Trabajador::where('dni', $validated['dni'])->firstOrFail();
            $trabajador->update(['empresa' => null]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al remover empresa: ' . $e->getMessage()
            ], 500);
        }
    }
}
