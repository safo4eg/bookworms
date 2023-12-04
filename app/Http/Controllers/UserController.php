<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['index', 'update']);
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $payload = $request->validated();
        Log::debug($user->login);
        $user->update(['role_id' => $payload['role_id']]);
        return new UserResource($user);
    }
}
