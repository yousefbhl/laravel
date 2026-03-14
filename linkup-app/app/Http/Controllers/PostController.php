<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        $posts = Post::with(['user', 'likes'])
            ->latest()
            ->get()
            ->map(function (Post $post) use ($currentUser) {
                $post->liked      = $post->isLikedBy($currentUser);
                $post->likesCount = $post->likes->count();
                return $post;
            });

        return view('posts.index', compact('posts', 'currentUser'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string|min:1|max:500',
        ], [
            'contenu.required' => 'Le contenu ne peut pas être vide.',
            'contenu.max'      => 'Le post ne peut pas dépasser 500 caractères.',
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'contenu' => $request->contenu,
        ]);

        $post->load('user');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'post'    => [
                    'id'         => $post->id,
                    'contenu'    => $post->contenu,
                    'created_at' => $post->created_at->diffForHumans(),
                    'user_name'  => $post->user->name,
                    'user_id'    => $post->user_id,
                    'liked'      => false,
                    'likes'      => 0,
                ],
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post publié !');
    }

    public function edit(Post $post)
    {
        // ← Gate::authorize() au lieu de $this->authorize()
        Gate::authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $request->validate([
            'contenu' => 'required|string|min:1|max:500',
        ]);

        $post->update(['contenu' => $request->contenu]);

        return redirect()->route('posts.index')
            ->with('success', 'Post modifié avec succès.');
    }

    public function destroy(Request $request, Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post supprimé.');
    }
}