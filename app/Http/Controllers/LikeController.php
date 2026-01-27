<?php

namespace App\Http\Controllers;
######## cambiarlo 
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        Like::where('user_id', Auth::id())
            ->where('post_id', $post->id)
            ->delete();

        return back();
    }
}
