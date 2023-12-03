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
        if($user->id !== $review->user->id) return false;
        return true;
    }

    public function delete(User $user, Review $review): bool
    {
        if($user->id !== $review->user->id) return false;
        return true;
    }
}
