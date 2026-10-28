<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión · Bitácora</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container login-contenedor">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h1 class="h4 mb-4">Bitácora de solicitudes</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label" for="email">Correo</label>
                        <input id="email" type="email" name="email" class="form-control"
                            value="{{ old('email') }}" autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input id="password" type="password" name="password" class="form-control">
                    </div>

                    <div class="form-check mb-3">
                        <input id="recordar" type="checkbox" name="recordar" value="1" class="form-check-input">
                        <label class="form-check-label" for="recordar">Mantener sesión iniciada</label>
                    </div>

                    <button class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>