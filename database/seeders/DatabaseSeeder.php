<?php

namespace Database\Seeders;

use App\Models\Rubro;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Salud', 'IT', 'Leyes', 'Comunicaciones', 'Educación', 'Finanzas'] as $nombre) {
            Rubro::firstOrCreate(['nombre' => $nombre]);
        }

        User::firstOrCreate(
            ['email' => 'admin@bitacora.test'],
            [
                'nombre'   => 'Administrador',
                'password' => Hash::make('cambiar-esta-clave'),
                'rol'      => 'admin',
            ]
        );
    }
}
