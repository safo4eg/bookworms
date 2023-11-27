<?php

namespace App\Services;

use App\Http\Requests\Evaluation\StoreEvaluationRequest;
use App\Models\Comment;
use App\Models\Critique;
use App\Models\Evaluation;
use App\Models\EvaluationType;
use App\Models\Reply;
use App\Models\Review;
use Illuminate\Validation\ValidationException;

class EvaluationableService
{
    private static StoreEvaluationRequest $request;
    private static Review|Critique|Comment|Reply $inputObj;
    private static array $payload = [];

    public static function handle(StoreEvaluationRequest $request, Review|Critique|Comment|Reply $inputObj): Evaluation
    {
        self::$request = $request;
        self::$inputObj = $inputObj;

        self::setEvaluationTypeId();
        self::setUserId();
        self::setEvaluationableInfo();
        self::checkUniquenessEvaluation();

        return Evaluation::create(self::$payload);
    }

    private static function setEvaluationTypeId()
    {
        $inputEvaluationType = self::$request->input('evaluation_type');
        $evaluationTypeModel = EvaluationType::where('title', $inputEvaluationType)->first();
        self::$payload['evaluation_type_id'] = $evaluationTypeModel->id;
    }

    private static function setUserId()
    {
        $userId = self::$request->user()->id;
        self::$payload['user_id'] = $userId;
    }

    private static function setEvaluationableInfo()
    {
        switch (self::$inputObj::class) {
            case Review::class:
                self::$payload['evaluationable_type'] = 'review';
                break;
            case Critique::class:
                self::$payload['evaluationable_type'] = 'critique';
                break;
            case Comment::class:
                self::$payload['evaluationable_type'] = 'comment';
                break;
            case Reply::class:
                self::$payload['evaluationable_type'] = 'reply';
                break;
        }

        self::$payload['evaluationable_id'] = self::$inputObj->id;
    }

    private static function checkUniquenessEvaluation()
    {
        $evaluation = Evaluation::where('user_id', self::$payload['user_id'])
            ->where('evaluationable_type', self::$payload['evaluationable_type'])
            ->where('evaluationable_id', self::$payload['evaluationable_id'])
            ->first();

        if($evaluation) {
            throw ValidationException::withMessages([
                'text' => 'The user can rate the entity once'
            ]);
        }
    }
}
