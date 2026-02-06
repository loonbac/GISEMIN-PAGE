<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamacion extends Model
{
    use HasFactory;

    protected $table = 'reclamaciones';

    protected $fillable = [
        'nombre_completo',
        'dni',
        'telefono',
        'email',
        'detalle_reclamo',
        'pedido',
        'estado',
        'respuesta',
        'fecha_respuesta',
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the status label in Spanish
     */
    public function getEstadoLabelAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'Por leer',
            'resuelto' => 'Leído',
            default => $this->estado,
        };
    }

    /**
     * Get the status color for UI
     */
    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => '#f59e0b',
            'en_proceso' => '#3b82f6',
            'resuelto' => '#10b981',
            'rechazado' => '#ef4444',
            default => '#6b7280',
        };
    }
}
