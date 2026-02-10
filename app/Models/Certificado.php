<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $table = 'certificados';
    protected $fillable = [
        'nombre',
        'dni',
        'curso',
        'fecha_emision',
        'codigo',
        'fecha_vencimiento',
        'estado',
        'observaciones',
        'drive_link',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
    ];

    /**
     * Scope para obtener certificados vigentes
     */
    public function scopeVigentes($query)
    {
        return $query->where('estado', 'vigente')
                     ->where('fecha_vencimiento', '>=', now()->toDateString());
    }

    /**
     * Get the worker associated with the certificate.
     */
    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'dni', 'dni');
    }

    /**
     * Scope para buscar por DNI o nombre
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('dni', 'like', "%{$termino}%")
              ->orWhere('nombre', 'like', "%{$termino}%");
        });
    }
}
