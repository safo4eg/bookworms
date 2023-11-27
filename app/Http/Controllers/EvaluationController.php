<?php

namespace App\Http\Controllers;

use App\Http\Requests\Evaluation\StoreEvaluationRequest;
use App\Http\Requests\Evaluation\UpdateEvaluationRequest;
use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Models\EvaluationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EvaluationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Evaluation::class, 'evaluation');
    }

    public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    {
        $evaluationTypeTitle = $request->input('evaluation_type');
        $evaluationTypeModel = EvaluationType::where('title', $evaluationTypeTitle)->first();
        $evaluation->update(['evaluation_type_id' => $evaluationTypeModel->id]);
        return new EvaluationResource($evaluation);
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
