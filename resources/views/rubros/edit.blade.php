@extends('layouts.app')

@section('contenido')
<h1 class="h3">Editar rubro</h1>
<form method="POST" action="{{ route('rubros.update', $rubro) }}">
    @method('PUT')
    @include('rubros._form')
</form>
@endsection