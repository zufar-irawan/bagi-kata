<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function home()
    {
        return view('home', ['posts' => Posts::all()]);
    }

    public function detailPost($id)
    {
        $post = Posts::findOrFail($id);

        return view('posts.detail', ['post' => $post]);
    }

    public function createView()
    {
        return view('posts.create_post');
    }

    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'text_content' => ['required', 'string'],
        ]);

        $test_id = "01kq8t33vtv6ynved01qnyxxqs";

        Posts::create([
            'user_id' => $test_id,
            'text_content' => $validated['text_content'],
        ]);

        return redirect()->back()->with('success', 'Post berhasil dibuat.');
    }

    public function updateView($id)
    {
        return view('posts.update_post', ['post' => Posts::findOrFail($id)]);
    }

    public function updatePost(Request $request, $id)
    {
        $validated = $request->validate([
            'text_content' => ['required', 'string'],
        ]);

        $post = Posts::findOrFail($id);
        $post->update([
            'text_content' => $validated['text_content'],
        ]);

        return redirect()->to('/post/' . $id);
    }

    public function deletePost($id)
    {
        $post = Posts::findOrFail($id);
        $post->delete();

        return redirect()->to('/')->with('success', 'Post berhasil dihapus.');
    }
}
