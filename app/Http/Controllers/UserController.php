<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $users = User::query()
            ->where('id', '!=', Auth::id())
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'q'));
    }
    public function show(User $user)
    {
        $user->loadCount(['followers', 'following']);

        return view('users.show', compact('user'));
    }
}
