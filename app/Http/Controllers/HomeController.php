<?php


namespace App\Http\Controllers;

use App\Models\Post;

class HomeController
{
    public function __invoke()
    {
        $posts = Post::with('category', 'user', 'tags')->paginate(10);
        $page = 'posts/';

        return view('pages.index', compact('posts', 'page'));
    }
}
