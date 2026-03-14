<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

/**
 * Policy pour contrôler les actions update/delete sur les posts.
 * Seul le propriétaire du post peut le modifier ou le supprimer.
 */
class PostPolicy
{
    /**
     * L'utilisateur peut modifier le post uniquement s'il en est l'auteur.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * L'utilisateur peut supprimer le post uniquement s'il en est l'auteur.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
