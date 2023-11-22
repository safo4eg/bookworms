<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $array = [];

        if(request()->route()->named('ratings.store', 'ratings.update'))
        {
            $array = [
                'avg' => $this->book->ratings()->avg('rating'),
                'user' => [
                    'id' => $this->id,
                    'rating' => $this->rating
                ]
            ];
        } else if(request()->route()->named(
            'books.index',
            'books.show',
            'books.update'
        ))
        {
            $array = [
                'id' => $this->id,
                'rating' => $this->rating
            ];
        }

        return $array;
    }
}
