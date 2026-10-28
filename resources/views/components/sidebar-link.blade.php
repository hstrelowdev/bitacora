@props(['ruta'])

<li>
    <a href="{{ route($ruta) }}"
        class="nav-link text-white {{ request()->routeIs(\Illuminate\Support\Str::beforeLast($ruta, '.') . '.*') ? 'active' : '' }}">
        {{ $slot }}
    </a>
</li>