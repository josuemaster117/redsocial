@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="d-flex justify-content-center">
  <div class="card text-center" style="max-width: 600px; width:100%;">
    <div class="card-body">

      <h3 class="mb-3">Bienvenido a tu Red Social 👋</h3>
      <p class="mb-4">Conecta, comparte y descubre.</p>

      @guest
        <div class="d-flex justify-content-center gap-3">
          <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Iniciar Sesión</a>
          <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registrarse</a>
        </div>
      @else
        <p class="mb-3">Ya estás dentro 👌</p>
        <a href="{{ route('posts.index') }}" class="btn btn-success btn-lg">Ir al Inicio</a>
      @endguest

    </div>
  </div>
</div>
@endsection
