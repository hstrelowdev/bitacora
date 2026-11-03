@extends('layouts.app')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Solicitudes</h1>
    <a href="{{ route('solicitudes.create') }}" class="btn btn-primary">Nueva solicitud</a>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Fecha</th><th>Título</th><th>Empleo</th><th>Solicitante</th>
                <th>Prioridad</th><th>Estado</th><th>Asignado a</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->fecha_solicitud->format('d-m-Y') }}</td>
                <td>{{ $solicitud->titulo }}</td>
                <td>
                    {{ $solicitud->empleo->nombre }}
                    <div class="small text-muted">{{ $solicitud->empleo->empresa->nombre }}</div>
                </td>
                <td>{{ $solicitud->solicitante }}</td>
                <td><x-prioridad-badge :prioridad="$solicitud->prioridad" /></td>
                <td><x-estado-badge :estado="$solicitud->estado" /></td>
                <td>{{ $solicitud->asignado?->nombre ?? 'Sin asignar' }}</td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('solicitudes.edit', $solicitud) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                    <form method="POST" action="{{ route('solicitudes.destroy', $solicitud) }}" class="d-inline"
                          data-confirmar="¿Eliminar esta solicitud y su historial?">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8">No hay solicitudes todavía.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{ $solicitudes->links() }}
@endsection