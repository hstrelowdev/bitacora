<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'solicitud_id',
    'usuario_id',
    'campo',
    'valor_anterior',
    'valor_nuevo',
    'comentario',
])]
class Historial extends Model
{
    protected $table = 'historial';

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
