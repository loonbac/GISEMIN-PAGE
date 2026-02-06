<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable = ['nombre', 'descripcion', 'uso_count', 'categoria'];

    /**
     * Obtener o crear un curso (sin categoría si es nuevo)
     */
    public static function obtenerOCrear($nombre)
    {
        $nombre = trim($nombre);
        
        $curso = self::where('nombre', $nombre)->first();
        
        if (!$curso) {
            // Nuevo curso sin categoría (será null)
            $curso = self::create([
                'nombre' => $nombre,
                'uso_count' => 1,
                'categoria' => null,
            ]);
        } else {
            // Incrementar contador de uso
            $curso->increment('uso_count');
        }
        
        return $curso;
    }

    /**
     * Obtener cursos ordenados por uso
     */
    public static function obtenerPorUso()
    {
        return self::orderBy('uso_count', 'desc')
                   ->orderBy('nombre', 'asc')
                   ->get();
    }

    /**
     * Obtener nombre de categoría con emoji
     */
    public function getNombreCategoriaAttribute()
    {
        return match($this->categoria) {
            'obligatorias' => '🔴 Capacitaciones Obligatorias / Normativas (SST)',
            'alto_riesgo' => '🟠 Trabajos de Alto Riesgo (TAR)',
            'emergencias' => '🟡 Emergencias y Primeros Auxilios',
            'equipos' => '🔵 Equipos, Maquinaria y Herramientas',
            'salud' => '🟢 Higiene Ocupacional y Salud',
            'ambiente' => '🟣 Medio Ambiente y SST (SSOMA)',
            'cultura' => '⚫ Capacitaciones Complementarias / Cultura Preventiva',
            'sectores' => '🔧 Capacitaciones Específicas (Según Sector)',
            default => '⚪ Sin Categorizar',
        };
    }
}
