@extends('layouts.app')
@section('title', 'Notificaciones')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="mb-0">Notificaciones</h4>

      <form method="POST" action="{{ route('notifications.readAll') }}">
        @csrf
        <button class="btn btn-outline-secondary btn-sm">Marcar todo como leído</button>
      </form>
    </div>

    @forelse($notifications as $n)
      <div class="card mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="{{ $n->read_at ? 'text-muted' : '' }}">
              {{ $n->data['message'] ?? 'Notificación' }}
            </div>

            @if(($n->data['type'] ?? null) === 'follow')
              <a href="{{ route('users.show', $n->data['follower_id']) }}" class="text-decoration-none">
                Ver perfil
              </a>
            @endif
          </div>

          @if(!$n->read_at)
            <span class="badge bg-primary">Nuevo</span>
          @endif
        </div>
      </div>
    @empty
      <div class="alert alert-info">No tienes notificaciones.</div>
    @endforelse

    <div class="mt-3">{{ $notifications->links() }}</div>
  </div>
</div>
@endsection
