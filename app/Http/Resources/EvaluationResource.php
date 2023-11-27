<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type->title,
            'user' => new UserResource($this->user),
            'evaluationable' => [
                'id' => $this->evaluationable->id,
                'type' => $this->evaluationable_type
            ]
        ];
    }
}
