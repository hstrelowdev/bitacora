<?php

namespace App\Observers;

use App\Models\Empleo;
use App\Models\Historial;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SolicitudObserver
{
    private const IGNORADOS = ['created_at', 'updated_at', 'fecha_cierre'];

    public function created(Solicitud $solicitud): void
    {
        $this->registrar($solicitud, 'creada', null, null, 'Solicitud creada');
    }

    public function updated(Solicitud $solicitud): void
    {
        foreach ($solicitud->getChanges() as $campo => $nuevo) {
            if (in_array($campo, self::IGNORADOS, true)) {
                continue;
            }

            $this->registrar(
                $solicitud,
                $campo,
                $this->valor($campo, $solicitud->getRawOriginal($campo)),
                $this->valor($campo, $nuevo)
            );
        }
    }

    private function valor(string $campo, mixed $valor): mixed
    {
        if ($valor === null) {
            return null;
        }

        return match ($campo) {
            'asignado_a' => User::find($valor)?->nombre ?? "#{$valor}",
            'empleo_id'  => Empleo::find($valor)?->nombre ?? "#{$valor}",
            default      => $valor,
        };
    }

    private function registrar(
        Solicitud $solicitud,
        string $campo,
        mixed $anterior,
        mixed $nuevo,
        ?string $comentario = null
    ): void {
        Historial::create([
            'solicitud_id'   => $solicitud->id,
            'usuario_id'     => Auth::id(),
            'campo'          => $campo,
            'valor_anterior' => $anterior,
            'valor_nuevo'    => $nuevo,
            'comentario'     => $comentario,
        ]);
    }
}