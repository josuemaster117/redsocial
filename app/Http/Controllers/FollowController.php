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
    {
        Auth::user()->following()->detach($user->id);

        return back()->with('success', 'Dejaste de seguir a ' . $user->name . ' ✅');
    }

    public function followQuery()
    {
        
    }
}
