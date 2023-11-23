<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\Rating;
use App\Models\User;

class RatingPolicy
{

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Rating $rating): bool
    {
        if($user->id !== $rating->user->id) return false;
        return true;
    }

    public function delete(User $user, Rating $rating): bool
    {
        if($user->id !== $rating->user->id) return false;
        return true;
    }
}
