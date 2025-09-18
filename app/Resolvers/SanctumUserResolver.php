<?php

namespace App\Resolvers;

use OwenIt\Auditing\Contracts\UserResolver as UserResolverContract;

class SanctumUserResolver implements UserResolverContract
{
    public function resolve() {

       // Tenta pegar via web
        if ($user = auth()->user()) {
            return $user;
        }

        // Tenta pegar via API/Sanctum
        if ($user = auth('sanctum')->user()) {
            return $user;
        }

        return null; // caso não tenha usuário logado
    }
}
