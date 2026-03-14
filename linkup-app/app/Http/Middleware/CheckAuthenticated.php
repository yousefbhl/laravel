<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware personnalisé d'authentification.
 * N'utilise PAS les middlewares intégrés de Laravel.
 * Vérifie la session manuellement et charge l'utilisateur.
 */
class CheckAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = session('user_id');

        // Aucun user en session → redirection vers login
        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Vérification que l'utilisateur existe toujours en base
        $user = User::find($userId);

        if (!$user) {
            session()->forget('user_id');
            return redirect()->route('login')
                ->with('error', 'Session invalide. Veuillez vous reconnecter.');
        }

        // On injecte l'utilisateur dans le Auth facade de Laravel
        // pour que les Policies ($this->authorize()) fonctionnent correctement
        Auth::setUser($user);

        return $next($request);
    }
}
