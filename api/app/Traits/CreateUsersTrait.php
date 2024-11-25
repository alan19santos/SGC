<?php

namespace App\Traits;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


trait CreateUsersTrait
{
    public function createUser(): User {
            return User::create($this->userData())  ;
    }

    public function userData(): array
    {
        return ["email" => "Teste@Uniti.com.br",
                "name" => "Teste Uniti",
                "password" => Hash::make('123456'),];
    }

    public function createFactoryAndGetToken(): string
    {
        return User::factory()->create()->createToken('auth_token')->plainTextToken;
    }


}
