<?php

namespace App\Http\Controllers;

use App\Exceptions\CredentialsException;
use App\Exceptions\UserException;
use App\Http\Request\LoginFormRequest;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws UserException
     * @throws CredentialsException
     */
    public function login(LoginFormRequest $request): JsonResponse {
        $request->validate(['email' => 'required|string|email|max:255', 'password' => 'required|string']);
        $user = $this->userService->login($request);
        return response()->json(['message' => 'Autenticado com sucesso!', 'token' => $user, 'user' => $this->loginUser($request->get('email'))]);
    }

    public function logout(Request $request): Response
    {
        $this->userService->logout($request);
        return response([], 204);
    }

    private function loginUser($email) {

        $user = $this->userService->findByEmail($email);
        return ['email' => $user->email,
            'name' => $user->name,
            'id' => $user->id,];
    }
}
