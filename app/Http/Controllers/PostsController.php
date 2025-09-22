<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request) 
    {
        $validatedData = $request->validate([
            'title'   => 'required|unique:posts|max:255',
            'content' => 'required',
        ]);
        
        Post::create([
            'title'   => $validatedData['title'],
            'slug'    => Str::slug($validatedData['title']),
            'content' => $validatedData['content'],
        ]);
        
        return redirect()->route('posts.index')->with('success', 'Post berhasil ditambahkan!');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title'   => ['required', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'content' => 'required',
        ]);

        $post->update([
            'title'   => $validatedData['title'],
            'slug'    => Str::slug($validatedData['title']),
            'content' => $validatedData['content']
        ]);

        return redirect()->route('posts.index')->with('success', 'Post berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus!');
    }

}