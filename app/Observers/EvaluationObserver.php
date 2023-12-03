<?php

namespace App\Observers;

use App\Events\UserPointsAdding;
use App\Events\UserPointsTakeAway;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Log;

class EvaluationObserver
{
    public function created(Evaluation $evaluation): void
    {
        switch ($evaluation->type->title) {
            case 'like':
                UserPointsAdding::dispatch($evaluation);
                break;
            case 'dislike':
                UserPointsTakeAway::dispatch($evaluation);
                break;
        }
    }
    public function updated(Evaluation $evaluation): void
    {
        if($evaluation->wasChanged('evaluation_type_id')) {
            switch ($evaluation->type->title) {
                case 'dislike':
                    UserPointsTakeAway::dispatch($evaluation);
                    UserPointsAdding::dispatch($evaluation);
                    break;
                case 'like':
                    UserPointsAdding::dispatch($evaluation);
                    UserPointsAdding::dispatch($evaluation);
                    break;
            }
        }
    }
    public function deleted(Evaluation $evaluation): void
    {
        switch ($evaluation->type->title) {
            case 'like':
                UserPointsTakeAway::dispatch($evaluation);
                break;
            case 'dislike':
                UserPointsAdding::dispatch($evaluation);
                break;
        }
    }
}
