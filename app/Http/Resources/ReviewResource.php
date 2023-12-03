<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment;
class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->user),
            'comments' => Comment\CommentableResource::collection($this->comments),
            'evaluations' => [
                'like' => $this->likes,
                'dislikes' => $this->dislikes
            ]
        ];
    }
}
