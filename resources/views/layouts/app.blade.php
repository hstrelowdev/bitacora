<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora de solicitudes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    <script src="{{ asset('js/confirmar.js') }}" defer></script>
</head>

<body class="bg-light">
    <div class="d-flex">

        <x-sidebar />

        <div class="flex-grow-1 contenido">
            <header class="d-lg-none bg-dark p-2">
                <button id="toggle-sidebar" type="button" class="btn btn-outline-light btn-sm">
                    ☰ Menú
                </button>
            </header>

            <main class="p-4">
                @if (session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @yield('contenido')
            </main>
        </div>

    </div>
</body>

</html>