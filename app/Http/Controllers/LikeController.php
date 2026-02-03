<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        Like::firstOrCreate([
            'user_id' => Auth::id(), ##Id usuario y post likeado
            'post_id' => $post->id,
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        Like::where('user_id', Auth::id())
            ->where('post_id', $post->id) ##Id usuario y post dislikeado
            ->delete();

        return back();
    }
}

// class LikeController extends Controller
// {
//     public function store($postId)
//     {
//         $userId = Auth::id();

//         // Verifica si ya existe el like
//         $exists = DB::table('likes')
//             ->where('user_id', $userId)  ##Id usuario y post likeado
//             ->where('post_id', $postId)
//             ->exists();

//         // Si no existe, lo inserta
//         if (!$exists) {
//             DB::table('likes')->insert([  ###inserta en tabla likes
//                 'user_id' => $userId, 
//                 'post_id' => $postId, ##busca a que post le dio like
//                 'created_at' => now(),
//                 'updated_at' => now(), ##
//             ]);
//         }

//         return back();
//     }

//     public function destroy($postId)
//     {
//         $userId = Auth::id();

//         DB::table('likes')
//             ->where('user_id', $userId)
//             ->where('post_id', $postId)
//             ->delete();

//         return back();
//     }
// }
