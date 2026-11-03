@props(['prioridad'])

@php
    $clase = match ($prioridad) {
        'alta'  => 'bg-danger',
        'media' => 'bg-warning text-dark',
        'baja'  => 'bg-secondary',
        default => 'bg-light text-dark',
    };
@endphp

<span class="badge {{ $clase }}">{{ \App\Models\Solicitud::PRIORIDADES[$prioridad] ?? $prioridad }}</span>