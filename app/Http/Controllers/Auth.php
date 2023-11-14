<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Hash;
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
        $payload = $request->validated();
        $user = User::where('login', $payload['login'])->first();
        if(!Hash::check($payload['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => 'The provided credentials are incorrect'
            ]);
        }

        return new JsonResponse([
            'data' => [
                'token' => $user->createToken('token')->plainTextToken
            ]
        ]);
    }

    public function logout(Request $request)
    {
        return '123';
    }
}
