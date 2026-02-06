<?php

namespace App\Http\Controllers;

use App\Models\Reclamacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReclamacionesController extends Controller
{
    /**
     * Store a newly created reclamacion.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:255',
            'dni' => 'required|string|size:8',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'detalle_reclamo' => 'required|string',
            'pedido' => 'required|string',
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.size' => 'El DNI debe tener 8 dígitos.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'detalle_reclamo.required' => 'La descripción del problema es obligatoria.',
            'pedido.required' => 'La solución esperada es obligatoria.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        Reclamacion::create([
            'nombre_completo' => $request->nombre_completo,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'detalle_reclamo' => $request->detalle_reclamo,
            'pedido' => $request->pedido,
            'estado' => 'pendiente',
        ]);

        return back()->with('success', '¡Su reclamación ha sido registrada exitosamente! Nos pondremos en contacto pronto.');
    }

    /**
     * Display a listing of reclamaciones for admin.
     */
    public function index()
    {
        $reclamaciones = Reclamacion::orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total' => Reclamacion::count(),
            'pendientes' => Reclamacion::where('estado', 'pendiente')->count(),
            'leidos' => Reclamacion::where('estado', 'resuelto')->count(),
        ];

        return view('admin.reclamaciones.index', compact('reclamaciones', 'stats'));
    }

    /**
     * Display a specific reclamacion.
     */
    public function show($id)
    {
        $reclamacion = Reclamacion::findOrFail($id);
        return view('admin.reclamaciones.show', compact('reclamacion'));
    }

    /**
     * Update the status of a reclamacion.
     */
    public function updateStatus(Request $request, $id)
    {
        $reclamacion = Reclamacion::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:pendiente,en_proceso,resuelto,rechazado',
            'respuesta' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Datos inválidos'], 400);
        }

        $reclamacion->estado = $request->estado;
        
        if ($request->respuesta) {
            $reclamacion->respuesta = $request->respuesta;
            $reclamacion->fecha_respuesta = now();
        }
        
        $reclamacion->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente',
            'reclamacion' => $reclamacion,
        ]);
    }

    /**
     * Delete a reclamacion.
     */
    public function destroy($id)
    {
        $reclamacion = Reclamacion::findOrFail($id);
        $reclamacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reclamación eliminada correctamente',
        ]);
    }
}
