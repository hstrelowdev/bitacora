@csrf

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="mb-3">
    <label class="form-label" for="nombre">Nombre</label>
    <input id="nombre" name="nombre" class="form-control"
        value="{{ old('nombre', $rubro->nombre ?? '') }}">
</div>

<div class="form-check mb-3">
    <input type="hidden" name="activo" value="0">
    <input id="activo" type="checkbox" name="activo" value="1" class="form-check-input"
        @checked(old('activo', $rubro->activo ?? true))>
    <label class="form-check-label" for="activo">Activo (aparece en los selects)</label>
</div>

<button class="btn btn-primary">Guardar</button>
<a href="{{ route('rubros.index') }}" class="btn btn-link">Cancelar</a>