<aside id="sidebar" class="sidebar bg-dark text-white d-flex flex-column p-3">
    <a href="/" class="fs-5 fw-semibold text-white text-decoration-none">Bitácora</a>
    <hr class="border-secondary">

    <ul class="nav nav-pills flex-column gap-1 mb-auto">
        <li class="text-uppercase small text-secondary mt-1 mb-1">Catálogos</li>
        <x-sidebar-link ruta="rubros.index">Rubros</x-sidebar-link>

        <li class="text-uppercase small text-secondary mt-3 mb-1">Empresas</li>
        <x-sidebar-link ruta="empresas.index">Empresas</x-sidebar-link>
        <x-sidebar-link ruta="empleos.index">Empleos</x-sidebar-link>
    </ul>

    <hr class="border-secondary">
    <div class="small mb-2">{{ auth()->user()->nombre }}</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-light w-100">Salir</button>
    </form>
</aside>