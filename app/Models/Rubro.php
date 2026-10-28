<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nombre', 'activo'])]
class Rubro extends Model
{
    protected $casts = ['activo' => 'boolean'];

    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }

    public function empleos()
    {
        return $this->hasMany(Empleo::class);
    }
}
