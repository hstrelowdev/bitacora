@extends('layouts.app')

@section('contenido')
<h1 class="h3">Nueva empresa</h1>
<form method="POST" action="{{ route('empresas.store') }}">
    @include('empresas._form')
</form>
@endsection