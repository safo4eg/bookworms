<?php

namespace App\Policies;

use App\Models\Rating;
use App\Models\User;

class RatingPolicy
{

    public function create(User $user): bool
    {
        $userId = request()->get('user_id');
        $bookId = request()->get('book_id');
        if($user->id != $userId) return false;
        else {
            $rating = Rating::where('user_id', $userId)
                ->where('book_id', $bookId)
                ->first();

            if($rating) return false;
            else return true;
        }
    }

    public function update(User $user, Rating $rating): bool
    {
        if($user->id !== $rating->user->id) return false;
        else return true;
    }

    public function delete(User $user, Rating $rating): bool
    {
        if($user->id !== $rating->user->id) return false;
        else return true;
    }
}
