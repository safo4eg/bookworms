<?php

namespace App\Policies;

use App\Models\Critique;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CritiquePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Critique $critique): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Critique $critique): bool
    {
        if($user->id !== $critique->user->id) return false;
        return true;
    }

    public function delete(User $user, Critique $critique): bool
    {
        if($user->id !== $critique->user->id) return false;
        return true;
    }

}
