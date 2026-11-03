@props(['estado'])

@php
    $clase = match ($estado) {
        'pendiente'  => 'bg-secondary',
        'en_proceso' => 'bg-primary',
        'terminada'  => 'bg-success',
        default      => 'bg-light text-dark',
    };
@endphp

<span class="badge {{ $clase }}">{{ \App\Models\Solicitud::ESTADOS[$estado] ?? $estado }}</span>