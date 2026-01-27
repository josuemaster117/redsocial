@extends('layouts.app')
@section('title', 'Buscar usuarios')

@section('content')
@php use Illuminate\Support\Facades\Auth; @endphp

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Buscar usuarios</h5>

                <form method="GET" action="{{ route('users.index') }}" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control"
                           placeholder="Busca por nombre o correo..."
                           value="{{ $q }}">
                    <button class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>

        @forelse($users as $u)
            <div class="card mb-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <img
                            src="{{ $u->avatar ? asset('storage/'.$u->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($u->name) }}"
                            width="45" height="45" class="rounded-circle border"
                        >
                        <div>
                            <a href="{{ route('users.show', $u) }}" class="text-decoration-none">
                                <strong>{{ $u->name }}</strong>
                            </a>
                            <div class="text-muted" style="font-size:.9rem;">{{ $u->email }}</div>
                        </div>
                    </div>

                    {{-- Seguir / dejar de seguir --}}
                    @if(Auth::user()->isFollowing($u))
                        <form method="POST" action="{{ route('users.unfollow', $u) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Dejar de seguir</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('users.follow', $u) }}">
                            @csrf
                            <button class="btn btn-primary btn-sm">Seguir</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-info">No se encontraron usuarios.</div>
        @endforelse

        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>
@endsection
