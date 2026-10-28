@extends('layouts.app')

@section('contenido')
<h1 class="h3">Nuevo empleo</h1>
<form method="POST" action="{{ route('empleos.store') }}">
    @include('empleos._form')
</form>
@endsection