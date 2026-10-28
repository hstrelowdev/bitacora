<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nombre', 'email', 'password', 'rol'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    public function solicitudesCreadas()
    {
        return $this->hasMany(Solicitud::class, 'creado_por');
    }

    public function solicitudesAsignadas()
    {
        return $this->hasMany(Solicitud::class, 'asignado_a');
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
