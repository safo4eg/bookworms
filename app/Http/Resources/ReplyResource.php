<?php

namespace App\Http\Resources;

use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'comment' => ['id' => $this->comment->id],
            'user' => new UserResource($this->user),
            'children' => $this->when(
                isset($this->children),
                ReplyResource::collection($this->children)
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
