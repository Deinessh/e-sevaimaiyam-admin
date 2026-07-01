<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'nullable|date',
        ]);
        
        $date = $request->input('date') ? date('F Y', strtotime($request->input('date'))) : date('F Y');

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $request->input('date') ?? now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }
    
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }
}
