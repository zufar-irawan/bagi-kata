<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function detailPost($id)
    {
        $post = Posts::findOrFail($id);
        $latestPost = Posts::whereNull('parent_id')
            ->where('id', '!=', $post->id)
            ->latest()->take(5)->get();

        $replies = $post->replies()->oldest()->get();

        $post->increment('views');

        return view('posts.detail', ['post' => $post, 'recentPosts' => $latestPost, 'replies' => $replies]);
    }

    public function updateView($id)
    {
        return view('posts.update_post', ['post' => Posts::findOrFail($id)]);
    }

    public function deletePost($id)
    {
        $post = Posts::findOrFail($id);
        $post->delete();

        return redirect()->to('/')->with('success', 'Post berhasil dihapus.');
    }
}
