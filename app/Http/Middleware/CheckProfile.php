<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Verifica se o usuário autenticado possui um dos perfis permitidos.
     *
     * Uso nas rotas: middleware('profile:admin,master')
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$profiles  Slugs dos perfis permitidos
     */
    public function handle(Request $request, Closure $next, string ...$profiles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Não autenticado.'
            ], 401);
        }

        // Carrega o perfil se não estiver carregado
        if (!$user->relationLoaded('profile')) {
            $user->load('profile');
        }

        $userProfile = $user->profile;

        if (!$userProfile) {
            return response()->json([
                'message' => 'Usuário sem perfil atribuído.'
            ], 403);
        }

        // Verifica se o slug do perfil do usuário está na lista de permitidos
        if (!in_array($userProfile->slug, $profiles)) {
            return response()->json([
                'message' => 'Acesso negado. Permissão insuficiente.',
                'required_profiles' => $profiles,
                'user_profile' => $userProfile->slug,
            ], 403);
        }

        return $next($request);
    }
}
