@extends('layouts.app')

@section('contenido')
<h1 class="h3">Editar solicitud</h1>
<form method="POST" action="{{ route('solicitudes.update', $solicitud) }}">
    @method('PUT')
    @include('solicitudes._form')
</form>
@endsection