@extends('layouts.app')

@section('contenido')
@push('estilos')
<link href="{{ asset('css/historial.css') }}" rel="stylesheet">
@endpush
<h1 class="h3">Editar solicitud</h1>
<form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
    @method('PUT')
    @include('solicitudes._form')
</form>
<h5 class="mt-4">Historial</h5>
<ul class="historial-lista">
    @forelse ($solicitud->historial as $item)
    <x-historial-item :item="$item" />
    @empty
    <li class="historial-vacio">Sin cambios registrados.</li>
    @endforelse
</ul>
@endsection