<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadores';

    protected $fillable = [
        'nombre',
        'dni',
        'empresa',
    ];

    /**
     * Get all certificates for this worker
     */
    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'dni', 'dni');
    }
}
