<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['empresa_id', 'rubro_id', 'nombre', 'descripcion'])]
class Empleo extends Model
{
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class);
    }
}
