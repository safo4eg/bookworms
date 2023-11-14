<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Auth extends Controller
{
    public function signup(SignupRequest $request)
    {
        $payload = $request->validated();
        $user = User::create($payload);
        return new JsonResponse([
            'data' => [
                'token' => $user->createToken('token')->plainTextToken
            ]
        ]);
    }

    public function login(LoginRequest $request)
    {

    }

    public function logout(Request $request)
    {
        return '123';
    }
}
