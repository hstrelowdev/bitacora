<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'empleo_id',
    'titulo',
    'descripcion',
    'solicitante',
    'prioridad',
    'estado',
    'fecha_solicitud',
    'fecha_cierre',
    'creado_por',
    'asignado_a',
])]

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_cierre'    => 'date',
    ];

    public function empleo()
    {
        return $this->belongsTo(Empleo::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public function asignado()
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function historial()
    {
        return $this->hasMany(Historial::class);
    }
}
