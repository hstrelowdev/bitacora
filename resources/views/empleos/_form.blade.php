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
    <label class="form-label" for="nombre">Nombre del empleo</label>
    <input id="nombre" name="nombre" class="form-control"
        value="{{ old('nombre', $empleo->nombre ?? '') }}">
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="empresa_id">Empresa</label>
        <select id="empresa_id" name="empresa_id" class="form-select">
            <option value="">Selecciona una empresa...</option>
            @foreach ($empresas as $empresa)
            <option value="{{ $empresa->id }}"
                @selected(old('empresa_id', $empleo->empresa_id ?? '') == $empresa->id)>
                {{ $empresa->nombre }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label" for="rubro_id">Rubro / área de cargo</label>
        <select id="rubro_id" name="rubro_id" class="form-select">
            <option value="">Selecciona un rubro...</option>
            @foreach ($rubros as $rubro)
            <option value="{{ $rubro->id }}"
                @selected(old('rubro_id', $empleo->rubro_id ?? '') == $rubro->id)>
                {{ $rubro->nombre }}
            </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3" class="form-control">{{ old('descripcion', $empleo->descripcion ?? '') }}</textarea>
</div>

<button class="btn btn-primary">Guardar</button>
<a href="{{ route('empleos.index') }}" class="btn btn-link">Cancelar</a>