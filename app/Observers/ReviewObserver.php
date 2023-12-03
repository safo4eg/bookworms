<?php

namespace App\Observers;

use App\Events\UserPointsAdding;
use App\Events\UserPointsTakeAway;
use App\Models\Review;

class ReviewObserver
{
    public function created(Review $review): void
    {
        UserPointsAdding::dispatch($review);
    }

    public function deleted(Review $review): void
    {
        UserPointsTakeAway::dispatch($review);
    }
}
