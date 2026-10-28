<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora de solicitudes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand">Bitácora</span>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('rubros.index') }}">Rubros</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('empresas.index') }}">Empresas</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('empleos.index') }}">Empleos</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        @if (session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('contenido')
    </div>
</body>

</html>