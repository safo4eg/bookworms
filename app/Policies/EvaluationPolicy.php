<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use function Symfony\Component\Translation\t;

class EvaluationPolicy
{

    public function update(User $user, Evaluation $evaluation): bool
    {
        if($user->id === $evaluation->user->id) return true;
        else return false;
    }

    public function delete(User $user, Evaluation $evaluation): bool
    {
        if($user->id === $evaluation->user->id) return true;
        else return false;
    }
}
