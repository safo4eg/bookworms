<?php

namespace App\Listeners;

use App\Events\UserPointsAdding;
use App\Events\UserPointsTakeAway;
use App\Models\Critique;
use App\Models\Evaluation;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class UserPointsSubscriber
{
    public function handlePointsAdding($event)
    {
        $pointsRecipient = null;
        $points = null;

        switch ($event->trigger::class) {
            case Review::class:
                $pointsRecipient = $event->trigger->user;
                $points = $pointsRecipient->points + 1;
                break;
            case Critique::class:
                $pointsRecipient = $event->trigger->user;
                $points = $pointsRecipient->points + 10;
                break;
            case Evaluation::class:
                $evaluationable = $event->trigger->evaluationable;
                $pointsRecipient = $evaluationable->user;
                switch ($evaluationable::class) {
                    case Review::class:
                        $points = $pointsRecipient->points + 1;
                        break;
                    case Critique::class:
                        $points = $pointsRecipient->points + 2;
                        break;
                }
                break;
        }

        $pointsRecipient->update(['points' => $points]);
    }

    public function handleTakeAwayPoints($event)
    {
        $pointsRecipient = null;
        $points = null;

        switch ($event->trigger::class) {
            case Evaluation::class:
                $evaluationable = $event->trigger->evaluationable;
                $pointsRecipient = $evaluationable->user;
                switch ($evaluationable::class) {
                    case Review::class:
                        $points = $pointsRecipient->points - 1;
                        break;
                    case Critique::class:
                        $points = $pointsRecipient->points - 2;
                        break;
                }
                break;
        }

        if($points <= 0) $points = 0;
        $pointsRecipient->update(['points' => $points]);
    }

    public function subscribe($event)
    {
        return [
            UserPointsAdding::class => 'handlePointsAdding',
            UserPointsTakeAway::class => 'handleTakeAwayPoints'
        ];
    }
}
