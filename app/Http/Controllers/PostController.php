<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::latest()->get());
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }
}
