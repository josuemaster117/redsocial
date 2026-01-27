<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Red Social</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background-color:#f0f2f5;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Mi Red Social</a>

            <div class="ms-auto">
                @auth
                {{-- 🔍 Buscar usuarios --}}
                <a class="nav-link d-inline me-2" href="{{ route('users.index') }}">Buscar</a>

                {{-- 🔔 Notificaciones --}}
                <a class="nav-link d-inline me-2 position-relative" href="{{ route('notifications.index') }}">
                    🔔
                    @if(auth()->user()->unreadNotifications->count())
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                    @endif
                </a>

                {{-- 👤 Perfil --}}
                <a href="/perfil" class="btn btn-outline-light btn-sm me-2">Perfil</a>

                {{-- 🚪 Salir --}}
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-danger btn-sm">Salir</button>
                </form>
                @else

                <a href="/login" class="btn btn-outline-light btn-sm me-2">Login</a>
                <a href="/register" class="btn btn-light btn-sm">Registro</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        {{-- Mensajes de éxito --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Errores de validación --}}
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </div>

</body>

</html>