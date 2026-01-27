@extends('layouts.app')

@section('title', 'Perfil')

@section('content')
@php use Illuminate\Support\Facades\Auth; @endphp

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-body">

                <div class="d-flex gap-3 align-items-center">
                    {{-- Avatar --}}
                    <img
                        src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}"
                        width="80" height="80"
                        class="rounded-circle border"
                        alt="avatar"
                    >

                    {{-- Info --}}
                    <div class="flex-grow-1">
                        <h4 class="mb-0">{{ $user->name }}</h4>
                        <div class="text-muted">{{ $user->email }}</div>

                        <div class="mt-2 text-muted">
                            Seguidores: <strong>{{ $user->followers_count }}</strong>
                            · Siguiendo: <strong>{{ $user->following_count }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Biografía --}}
                @if($user->bio)
                    <div class="mt-3">
                        <strong>Biografía</strong>
                        <div class="text-muted">{{ $user->bio }}</div>
                    </div>
                @endif

                {{-- ✅ BOTÓN DEBAJO DE LA BIO --}}
                @if(Auth::id() !== $user->id)
                    <div class="mt-3 d-flex gap-2 align-items-center">
                        @if(Auth::user()->isFollowing($user))
                            <form method="POST" action="{{ route('users.unfollow', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger">Dejar de seguir</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('users.follow', $user) }}">
                                @csrf
                                <button class="btn btn-primary">Seguir</button>
                            </form>
                        @endif

                        @if(Auth::user()->isFriendWith($user))
                            <span class="badge bg-success">Amigos ✅</span>
                        @endif
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection
