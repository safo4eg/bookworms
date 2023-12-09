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
        if(in_array($user->role_id, [2, 3])) return true;
        else if($user->role_id === 1 AND $user->id === $reply->user->id) return true;
        else return false;
    }

    public function delete(User $user, Reply $reply): bool
    {
        if(in_array($user->role_id, [2, 3])) return true;
        else if($user->role_id === 1 AND $user->id === $reply->user->id) return true;
        else return false;
    }
}
