<?php

namespace App\Http\Controllers;

use App\Http\Requests\Evaluation\StoreEvaluationRequest;
use App\Http\Resources\EvaluationResource;
use App\Models\Comment;
use App\Models\Critique;
use App\Models\Evaluation;
use App\Models\EvaluationType;
use App\Models\Reply;
use App\Models\Review;
use App\Services\EvaluationableService;
use Illuminate\Validation\ValidationException;

class EvaluationableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function reviewStore(StoreEvaluationRequest $request, Review $review)
    {
        $evaluation = EvaluationableService::handle($request, $review);
        return new EvaluationResource($evaluation);
    }

    public function critiqueStore(StoreEvaluationRequest $request, Critique $critique)
    {
        $evaluation = EvaluationableService::handle($request, $critique);
        return new EvaluationResource($evaluation);
    }

    public function commentStore(StoreEvaluationRequest $request, Comment $comment)
    {
        $evaluation = EvaluationableService::handle($request, $comment);
        return new EvaluationResource($evaluation);
    }

    public function replyStore(StoreEvaluationRequest $request, Reply $reply)
    {
        $evaluation = EvaluationableService::handle($request, $reply);
        return new EvaluationResource($evaluation);
    }
}
