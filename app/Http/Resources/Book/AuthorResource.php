<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\GenreResource;
use App\Http\Resources\RatingResource;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $userRating = null;
        $user = auth()->user();
        if(isset($user)) {
            $userRating = $user->ratings()
                ->where('book_id', $this->id)
                ->first();
        }
        return [
            'id' => $this->id,
            'image_url' => $this->image_url,
            'title' => $this->title,
            'desc' => $this->desc,
            'date_of_writing' => $this->date_of_writing,
            'genres' => GenreResource::collection($this->genres),
            'rating' => isset($userRating)
                ? new RatingResource($userRating)
                : ['avg' => $this->ratings()->avg('rating'), 'id' => null, 'rating' => null],
        ];
    }
}
