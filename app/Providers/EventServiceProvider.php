<?php

namespace App\Providers;

use App\Listeners\UserPointsSubscriber;
use App\Models\Critique;
use App\Models\Evaluation;
use App\Models\Review;
use App\Models\User;
use App\Observers\CritiqueObserver;
use App\Observers\EvaluationObserver;
use App\Observers\ReviewObserver;
use App\Observers\UserObserver;
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
        UserPointsSubscriber::class
    ];

    public function boot(): void
    {
        Review::observe(ReviewObserver::class);
        Critique::observe(CritiqueObserver::class);
        Evaluation::observe(EvaluationObserver::class);
        User::observe(UserObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
