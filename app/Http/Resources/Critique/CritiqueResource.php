<?php

namespace App\Http\Resources\Critique;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Book;

class CritiqueResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->user),
            'book' => new Book\CritiqueResource($this->book),
            'evaluations' => [
                'like' => $this->likes,
                'dislikes' => $this->dislikes
            ]
        ];
    }
}
