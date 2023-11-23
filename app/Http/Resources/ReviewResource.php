<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $array = [
            'id' => $this->id,
            'text' => $this->text,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'book_id' => $this->book->id,
            'user' => new UserResource($this->user)
        ];

        if(request()->route()->named(
            'books.index',
            'books.show',
            'books.store',
            'books.update'
        ))
        {
            unset($array['book_id']);
        }

        return $array;
    }
}
