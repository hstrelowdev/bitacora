@stack('estilos')
@props(['item'])

<li class="historial-item">
    <span class="historial-fecha">{{ $item->created_at->format('d/m/Y H:i') }}</span>
    <span class="historial-usuario">{{ $item->usuario->nombre ?? 'Sistema' }}</span>

    @if ($item->campo === 'creada')
        <span class="historial-detalle">{{ $item->comentario }}</span>
    @else
        <span class="historial-detalle">
            cambió <strong>{{ $item->etiquetaCampo() }}</strong>
            de <em>{{ $item->valorLegible($item->valor_anterior) }}</em>
            a <em>{{ $item->valorLegible($item->valor_nuevo) }}</em>
        </span>
    @endif
</li>