@extends('layouts.app')

@section('contenido')
<h1 class="h3">Editar empleo</h1>
<form method="POST" action="{{ route('empleos.update', $empleo) }}">
    @method('PUT')
    @include('empleos._form')
</form>
@endsection