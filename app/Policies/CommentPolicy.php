<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }
    public function view(?User $user, Comment $comment): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Comment $comment): bool
    {
        if(in_array($user->role_id, [2, 3])) return true;
        else if($user->role_id === 1 AND $user->id === $comment->user->id) return true;
        else return false;
    }

    public function delete(User $user, Comment $comment): bool
    {
        if(in_array($user->role_id, [2, 3])) return true;
        else if($user->role_id === 1 AND $user->id === $comment->user->id) return true;
        else return false;
    }
}
