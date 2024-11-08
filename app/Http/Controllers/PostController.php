<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    //
    public function index()
    {
        return view('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function edit(Post $post)
    {
        if (Gate::denies('update', $post)) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }
}
