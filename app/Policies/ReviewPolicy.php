<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class   ReviewPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Review $review): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Review $review): bool
    {
        if(in_array($user->role_id, [2, 3])) return true;
        else if($user->role_id === 1 AND $user->id === $review->user->id) return true;
        else return false;
    }

    public function delete(User $user, Review $review): bool
    {
        if(in_array($user->role_id, [2, 3])) return true;
        else if($user->role_id === 1 AND $user->id === $review->user->id) return true;
        else return false;
    }
}
