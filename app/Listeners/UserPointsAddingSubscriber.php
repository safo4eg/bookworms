<?php

namespace App\Listeners;

use App\Events\UserPointsAdding;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class UserPointsAddingSubscriber
{
    public function handlePointsAdding($event)
    {

        if($event->trigger::class === Review::class) {
            $user = $event->trigger->user;
            $points = $user->points + 1;
            $user->update(['points' => $points]);
        }
    }

    public function subscribe($event)
    {
        return [
            UserPointsAdding::class => 'handlePointsAdding'
        ];
    }
}
