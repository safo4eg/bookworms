<?php

namespace App\Providers;

use App\Listeners\UserPointsAddingSubscriber;
use App\Models\Review;
use App\Observers\ReviewObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $subscribe = [
        UserPointsAddingSubscriber::class
    ];

    public function boot(): void
    {
        Review::observe(ReviewObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
