<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like/unlike sur un post.
     * Retourne toujours du JSON pour AJAX.
     */
    public function toggle(Request $request, Post $post)
    {
        $user   = Auth::user();
        $like   = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Déjà liké → on retire le like
            $like->delete();
            $liked = false;
        } else {
            // Pas encore liké → on ajoute
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked'   => $liked,
            'count'   => $post->likes()->count(),
        ]);
    }
}
