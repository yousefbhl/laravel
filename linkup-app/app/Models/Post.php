<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'contenu'];

    // Un post appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un post a plusieurs likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Vérifie si un utilisateur donné a liké ce post
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
