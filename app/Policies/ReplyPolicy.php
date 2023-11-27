<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReplyPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Reply $reply): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Reply $reply): bool
    {
        if($user->is_moder) return true;
        else if($user->id === $reply->user->id) return true;
        else return false;
    }

    public function delete(User $user, Reply $reply): bool
    {
        if($user->is_moder) return true;
        else if($user->id === $reply->user->id) return true;
        else return false;
    }
}
