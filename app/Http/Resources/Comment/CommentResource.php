<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'user' => new UserResource($this->user),
            "{$this->commentable_type}" => ['id' => $this->commentable->id],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
