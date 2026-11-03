<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

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

    public function etiquetaCampo(): string
    {
        return Solicitud::CAMPOS[$this->campo] ?? $this->campo;
    }

    public function valorLegible(?string $valor): string
    {
        if ($valor === null || $valor === '') {
            return '—';
        }

        return match ($this->campo) {
            'estado' => Solicitud::ESTADOS[$valor] ?? $valor,
            'prioridad' => Solicitud::PRIORIDADES[$valor] ?? $valor,
            default => $valor,
        };
    }
}
