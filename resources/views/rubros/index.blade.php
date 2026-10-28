@extends('layouts.app')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Rubros</h1>
    <a href="{{ route('rubros.create') }}" class="btn btn-primary">Nuevo rubro</a>
</div>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Estado</th>
            <th class="text-end">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($rubros as $rubro)
        <tr>
            <td>{{ $rubro->nombre }}</td>
            <td>
                @if ($rubro->activo)
                <span class="badge bg-success">Activo</span>
                @else
                <span class="badge bg-secondary">Inactivo</span>
                @endif
            </td>
            <td class="text-end">
                <a href="{{ route('rubros.edit', $rubro) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                <form method="POST" action="{{ route('rubros.destroy', $rubro) }}" class="d-inline"
                    onsubmit="return confirm('¿Eliminar este rubro?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3">No hay rubros todavía.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $rubros->links() }}
@endsection