<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FollowedYou;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if ($user->id === Auth::id()) return back();

        //Esto hace que se relacionen sin duplicados
        Auth::user()->following()->syncWithoutDetaching([$user->id]);
        
        //Notificar al usuario que ha sido seguido
        $user->notify(new FollowedYou(Auth::id(), Auth::user()->name));
        return back()->with('success', 'Ahora sigues a ' . $user->name . ' ✅');
    }

    public function unfollow(User $user)
    {    // {        verifica que sigue a esa persona
        Auth::user()->following()->detach($user->id);

        return back()->with('success', 'Dejaste de seguir a ' . $user->name . ' ✅');
    }

    public function followQuery()
    {
        
    }
}

// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use App\Notifications\FollowedYou;
// use App\Models\User;

// public function followQuery(User $user)
// {
//     if ($user->id === Auth::id()) return back();

//     // Verificar si ya existe la relación
//     $exists = DB::table('follows')
//         ->where('follower_id', Auth::id())
//         ->where('followed_id', $user->id)
//         ->exists();

//     // Si no existe, la creamos
//     if (!$exists) {
//         DB::table('follows')->insert([
//             'follower_id' => Auth::id(),
//             'followed_id' => $user->id,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         // Notificación
//         $user->notify(new FollowedYou(Auth::id(), Auth::user()->name));
//     }
//      sigues a ese usuario
//     return back()->with('success', 'Ahora sigues a ' . $user->name . ' ✅');
// }
// vamos a eliminar la relación de seguimiento

// public function unfollowQuery(User $user)
// {     lo que hace es eliminar la relacion entre el usuario autenticado y el usuario que se va a dejar de seguir
//     DB::table('follows')
//         ->where('follower_id', Auth::id())
//         ->where('followed_id', $user->id)
//         ->delete();
//      nos desvuelceve a la página anterior con un mensaje de éxito
//     return back()->with('success', 'Dejaste de seguir a ' . $user->name . ' ✅');
// }


