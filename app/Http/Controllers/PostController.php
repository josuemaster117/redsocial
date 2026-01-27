<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $followingIds = $user->following()->pluck('users.id');

        $posts = Post::with('user')
            ->withCount('likes')
            ->whereIn('user_id', $followingIds->push($user->id))
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }



    public function store(Request $request)
    {
       $request->validate([
        'content' => 'required|string|max:500',
        'image'   => 'nullable|image|max:2048', // 2MB
    ]);

    $path = null;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('posts', 'public');
    }

    Post::create([
        'user_id' => Auth::id(),
        'content' => $request->content,
        'image'   => $path,
    ]);

    return back()->with('success', 'Publicación creada ✅');
    }
    public function destroy(Post $post)
{
    // Solo el dueño puede borrar
    if ($post->user_id !== Auth::id()) {
        abort(403);
    }

    // Borrar imagen si existe
    if ($post->image) {
        Storage::disk('public')->delete($post->image);
    }

    $post->delete();

    return back()->with('success', 'Publicación eliminada ✅');
}
}
