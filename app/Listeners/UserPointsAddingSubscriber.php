<?php

namespace App\Listeners;

use App\Events\UserPointsAdding;
use App\Models\Critique;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class UserPointsAddingSubscriber
{
    public function handlePointsAdding($event)
    {
        $user = null;
        $points = null;

        switch ($event->trigger::class) {
            case Review::class:
                $user = $event->trigger->user;
                $points = $user->points++;
                break;
            case Critique::class:
                $user = $event->trigger->user;
                $points = $user->points + 10;
                break;
        }

        $user->update(['points' => $points]);
    }

    public function subscribe($event)
    {
        return [
            UserPointsAdding::class => 'handlePointsAdding'
        ];
    }
}
