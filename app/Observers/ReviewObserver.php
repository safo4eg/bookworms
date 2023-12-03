<?php

namespace App\Observers;

use App\Events\UserPointsAdding;
use App\Models\Review;
use Illuminate\Support\Facades\Log;

class ReviewObserver
{
    public function created(Review $review): void
    {
        UserPointsAdding::dispatch($review);
    }

    public function deleted(Review $review): void
    {
        //
    }
}
