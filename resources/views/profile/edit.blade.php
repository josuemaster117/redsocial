@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
<style>
  .color-box {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid #ddd;
  }
</style>

<div class="row justify-content-center">
  <div class="col-md-6">

    <div class="card">
      <div class="card-body">
        <h4 class="mb-3">Perfil</h4>

        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>

    {{-- Tarjeta info usuario --}}
    <div class="card mb-3">
      <div class="card-body d-flex gap-3 align-items-center">
        <img
          src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
          width="90" height="90" class="rounded-circle"
          alt="avatar">

        <div class="flex-grow-1">
          <h4 class="mb-0">{{ $user->name }}</h4>
          <div class="text-muted">{{ $user->email }}</div>

          @if($user->ciudad)
            <div class="text-muted mt-1">📍 {{ $user->ciudad }}</div>
          @endif

          @if($user->bio)
            <div class="mt-2">{{ $user->bio }}</div>
          @endif
        </div>
      </div>
    </div>

    {{-- Form editar --}}
    <div class="card">
      <div class="card-body">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')

          {{-- Avatar actual (si tiene) --}}
          @if(auth()->user()->avatar)
            <div class="mb-3">
              <label class="form-label">Foto actual</label><br>
              <img src="{{ asset('storage/'.auth()->user()->avatar) }}" width="120" class="rounded">
            </div>
          @endif

          {{-- Subir nuevo avatar --}}
          <div class="mb-3">
            <label class="form-label">Cambiar foto</label>
            <input type="file" name="avatar" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Biografía</label>
            <input type="text" name="bio"
              value="{{ old('bio', $user->bio) }}"
              class="form-control"
              placeholder="Cuéntanos algo sobre ti">
          </div>

          <div class="mb-3">
            <label class="form-label">Ciudad</label>
            <input type="text" name="ciudad" class="form-control"
              value="{{ old('ciudad', $user->ciudad) }}"
              placeholder="Ej: Quito">
          </div>

          <div class="mb-3">
            <label class="form-label">Color favorito</label>
            <input type="text" name="color_favorito" class="form-control"
              value="{{ old('color_favorito', $user->color_favorito) }}"
              placeholder="Ej: #ff0000 o rojo">
            <small class="text-muted">Puedes escribir un color (rojo) o un código HEX (#ff0000).</small>
          </div>

          <button class="btn btn-primary w-100">Guardar Cambios</button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
