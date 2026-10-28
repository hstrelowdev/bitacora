@extends('layouts.app')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Empresas</h1>
    <a href="{{ route('empresas.create') }}" class="btn btn-primary">Nueva empresa</a>
</div>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Rubro</th>
            <th>Descripción</th>
            <th class="text-end">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($empresas as $empresa)
        <tr>
            <td>{{ $empresa->nombre }}</td>
            <td>{{ $empresa->rubro->nombre }}</td>
            <td>{{ \Illuminate\Support\Str::limit($empresa->descripcion, 60) }}</td>
            <td class="text-end">
                <a href="{{ route('empresas.edit', $empresa) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                <form method="POST" action="{{ route('empresas.destroy', $empresa) }}" class="d-inline"
                    data-confirmar="¿Eliminar este rubro?" ('¿Eliminar esta empresa?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No hay empresas todavía.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{ $empresas->links() }}
@endsection