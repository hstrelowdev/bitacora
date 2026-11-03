@extends('layouts.app')

@section('contenido')
<h1 class="h3">Nueva solicitud</h1>
<form method="POST" action="{{ route('solicitudes.store') }}">
    @include('solicitudes._form')
</form>
@endsection