<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profiles.me', [
            'user' => Auth::user(),
            'posts' => Posts::where('user_id', Auth::user()->id)->get(),
        ]);
    }

    public function show($id)
    {
        $user = \App\Models\User::findOrFail($id);
        if (Auth::check() && $user->id === Auth::id()) {
            return redirect('/me');
        }

        return view('profiles.profile', [
            'user' => $user,
            'posts' => Posts::where('user_id', $user->id)->get(),
        ]);
    }

    public function editView()
    {
        return view('profiles.edit');
    }

    public function favoriteView()
    {
        $favorites = Auth::user()->favoritePosts()->latest()->get();

        return view('profiles.favorite', ['posts' => $favorites]);
    }
}
