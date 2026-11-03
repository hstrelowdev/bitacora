@extends('layouts.app')

@section('contenido')
<h1 class="h3">Editar empresa</h1>
<form method="POST" action="{{ route('empresas.update', $empresa) }}">
    @method('PUT')
    @include('empresas._form')
</form>
@endsection