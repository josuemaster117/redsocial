@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Crear publicación --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">Crear publicación</h5>

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <textarea name="content" class="form-control" rows="3"
                        placeholder="¿Qué estás pensando?">{{ old('content') }}</textarea>

                    <input type="file" name="image" class="form-control mt-2" accept="image/*">

                    <button class="btn btn-primary mt-3">Publicar</button>
                </form>
            </div>
        </div>

        {{-- Feed --}}
        @php use Illuminate\Support\Facades\Auth; @endphp

        @forelse($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $post->user->avatar 
            ? asset('storage/'.$post->user->avatar) 
            : 'https://ui-avatars.com/api/?name='.urlencode($post->user->name) }}"
                                width="40" height="40" class="rounded-circle">

                            <div>
                                <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none">
                                    <strong>{{ $post->user->name }}</strong>
                                </a>
                                <div class="text-muted" style="font-size:0.9rem;">
                                    {{ $post->user->email }}
                                </div>
                            </div>
                        </div>

                        <small class="text-muted ms-2">{{ $post->created_at->diffForHumans() }}</small>
                    </div>

                    @if($post->user_id === Auth::id())
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('¿Eliminar publicación?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                    </form>
                    @endif
                </div>

                <p class="mt-2 mb-0">{{ $post->content }}</p>

                @if($post->image)
                <img src="{{ asset('storage/'.$post->image) }}"
                    class="img-fluid rounded mt-2"
                    alt="imagen del post">
                @endif

                {{-- ✅ Likes (PASO 6.7) --}}
                <div class="mt-2 d-flex align-items-center gap-2">
                    <span class="text-muted">{{ $post->likes_count }} likes</span>

                    @if($post->likedByAuthUser())
                    <form action="{{ route('posts.unlike', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Quitar ❤️</button>
                    </form>
                    @else
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary">Me gusta ❤️</button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class="alert alert-info">
            Aún no hay publicaciones.
        </div>
        @endforelse

        <div class="mt-3">
            {{ $posts->links() }}
        </div>

    </div>
</div>
@endsection