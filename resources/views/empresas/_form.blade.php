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
        value="{{ old('nombre', $empresa->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label" for="rubro_id">Rubro</label>
    <select id="rubro_id" name="rubro_id" class="form-select">
        <option value="">Selecciona un rubro...</option>
        @foreach ($rubros as $rubro)
        <option value="{{ $rubro->id }}"
            @selected(old('rubro_id', $empresa->rubro_id ?? '') == $rubro->id)>
            {{ $rubro->nombre }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label" for="descripcion">Descripción (a qué se dedica)</label>
    <textarea id="descripcion" name="descripcion" rows="3" class="form-control">{{ old('descripcion', $empresa->descripcion ?? '') }}</textarea>
</div>

<button class="btn btn-primary">Guardar</button>
<a href="{{ route('empresas.index') }}" class="btn btn-link">Cancelar</a>