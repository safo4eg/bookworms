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
        if($user->id === $comment->user->id) return true;
        else return false;
    }

    public function delete(User $user, Comment $comment): bool
    {
        if($user->is_moder) return true;
        else if($user->id === $comment->user->id) return true;
        else return false;
    }
}
