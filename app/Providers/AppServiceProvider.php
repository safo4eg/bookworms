<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Critique;
use App\Models\Review;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Relation::morphMap([
            'review' => Review::class,
            'critique' => Critique::class
        ]);
    }
}
