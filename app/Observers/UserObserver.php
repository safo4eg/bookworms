<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function updated(User $user): void
    {
        if($user->wasChanged('points')) {
            $user->changeRank();
        }
    }

}
