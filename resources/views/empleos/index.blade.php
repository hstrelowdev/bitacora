@extends('layouts.app')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Empleos</h1>
    <a href="{{ route('empleos.create') }}" class="btn btn-primary">Nuevo empleo</a>
</div>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Empleo</th>
            <th>Empresa</th>
            <th>Rubro</th>
            <th>Creado</th>
            <th class="text-end">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($empleos as $empleo)
        <tr>
            <td>{{ $empleo->nombre }}</td>
            <td>{{ $empleo->empresa->nombre }}</td>
            <td>{{ $empleo->rubro->nombre }}</td>
            <td>{{ $empleo->created_at->format('d-m-Y') }}</td>
            <td class="text-end">
                <a href="{{ route('empleos.edit', $empleo) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                <form method="POST" action="{{ route('empleos.destroy', $empleo) }}" class="d-inline"
                    onsubmit="return confirm('¿Eliminar este empleo?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No hay empleos todavía.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $empleos->links() }}
@endsection