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
    <label class="form-label" for="titulo">Título</label>
    <input id="titulo" name="titulo" class="form-control"
           value="{{ old('titulo', $solicitud->titulo ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label" for="empleo_id">Empleo</label>
    <select id="empleo_id" name="empleo_id" class="form-select">
        <option value="">Selecciona un empleo...</option>
        @foreach ($empleos as $empleo)
            <option value="{{ $empleo->id }}"
                @selected(old('empleo_id', $solicitud->empleo_id ?? '') == $empleo->id)>
                {{ $empleo->nombre }} — {{ $empleo->empresa->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label" for="solicitante">Solicitante</label>
    <input id="solicitante" name="solicitante" class="form-control"
           value="{{ old('solicitante', $solicitud->solicitante ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label" for="descripcion">Descripción</label>
    <textarea id="descripcion" name="descripcion" rows="3" class="form-control">{{ old('descripcion', $solicitud->descripcion ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label" for="fecha_solicitud">Fecha</label>
        <input id="fecha_solicitud" type="date" name="fecha_solicitud" class="form-control"
               value="{{ old('fecha_solicitud', isset($solicitud) ? $solicitud->fecha_solicitud->format('Y-m-d') : now()->toDateString()) }}">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label" for="prioridad">Prioridad</label>
        <select id="prioridad" name="prioridad" class="form-select">
            @foreach (\App\Models\Solicitud::PRIORIDADES as $valor => $etiqueta)
                <option value="{{ $valor }}"
                    @selected(old('prioridad', $solicitud->prioridad ?? 'media') === $valor)>
                    {{ $etiqueta }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label" for="estado">Estado</label>
        <select id="estado" name="estado" class="form-select">
            @foreach (\App\Models\Solicitud::ESTADOS as $valor => $etiqueta)
                <option value="{{ $valor }}"
                    @selected(old('estado', $solicitud->estado ?? 'pendiente') === $valor)>
                    {{ $etiqueta }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label" for="asignado_a">Asignado a</label>
        <select id="asignado_a" name="asignado_a" class="form-select">
            <option value="">Sin asignar</option>
            @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id }}"
                    @selected(old('asignado_a', $solicitud->asignado_a ?? '') == $usuario->id)>
                    {{ $usuario->nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<button class="btn btn-primary">Guardar</button>
<a href="{{ route('solicitudes.index') }}" class="btn btn-link">Cancelar</a>