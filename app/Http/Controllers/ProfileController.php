<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = DB::table('users')
            ->select('id', 'name', 'email', 'bio', 'color_favorito', 'avatar', 'ciudad')
            ->where('id', Auth::id())
            ->first();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user(); // ✅ ESTE es el user de la tabla users (Eloquent)

        $data = $request->validate([
            'bio' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'ciudad' => ['nullable', 'string', 'max:60'],
            'color_favorito' => ['nullable', 'string', 'max:20'],
        ]);

        // ✅ Guardar avatar si suben uno
        if ($request->hasFile('avatar')) {

            // borrar anterior si existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update([
            'bio' => $data['bio'] ?? $user->bio,
            'avatar' => $data['avatar'] ?? $user->avatar,
            'ciudad' => $data['ciudad'] ?? $user->ciudad,
            'color_favorito' => $data['color_favorito'] ?? $user->color_favorito,
        ]);

        return redirect()->route('profile.edit')->with('status', 'Perfil actualizado ✅');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
