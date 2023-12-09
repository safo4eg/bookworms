<?php

namespace App\Policies;

use App\Models\User;

class AuthorPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role_id, [2, 3]);
    }

    public function update(User $user): bool
    {
        return in_array($user->role_id, [2, 3]);
    }

    public function delete(User $user): bool
    {
        return in_array($user->role_id, [2, 3]);
    }
}
