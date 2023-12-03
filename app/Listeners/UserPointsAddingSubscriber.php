<?php

namespace App\Listeners;

use App\Events\UserPointsAdding;
use Illuminate\Support\Facades\Log;

class UserPointsAddingSubscriber
{
    public function handlePointsAdding()
    {
        //
    }

    public function subscribe($event)
    {
        return [
            UserPointsAdding::class => 'handlePointsAdding'
        ];
    }
}
