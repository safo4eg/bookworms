<?php

namespace App\Observers;

use App\Events\UserPointsAdding;
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
                Log::debug('поставлен дизлайк');
                break;
        }
    }
    public function updated(Evaluation $evaluation): void
    {
        //
    }
    public function deleted(Evaluation $evaluation): void
    {
        //
    }
}
