@extends('layouts.app')

@section('contenido')
<h1 class="h3">Nuevo rubro</h1>
<form method="POST" action="{{ route('rubros.store') }}">
    @include('rubros._form')
</form>
@endsection