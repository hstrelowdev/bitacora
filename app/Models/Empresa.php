<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['rubro_id', 'nombre', 'descripcion'])]
class Empresa extends Model
{
    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function empleos()
    {
        return $this->hasMany(Empleo::class);
    }
}
