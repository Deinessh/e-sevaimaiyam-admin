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
            'image_file' => 'nullable|image|max:5120',
            'image_url' => 'nullable|url|max:2048',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $filename);
            $imagePath = url('uploads/' . $filename);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => $imagePath,
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
