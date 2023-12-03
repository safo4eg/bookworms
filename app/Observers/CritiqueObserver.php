<?php

namespace App\Observers;

use App\Events\UserPointsAdding;
use App\Events\UserPointsTakeAway;
use App\Models\Critique;

class CritiqueObserver
{
    public function created(Critique $critique): void
    {
        UserPointsAdding::dispatch($critique);
    }

    public function deleted(Critique $critique): void
    {
        UserPointsTakeAway::dispatch($critique);
    }
}
