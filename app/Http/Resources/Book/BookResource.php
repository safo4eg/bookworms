<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\GenreResource;
use App\Http\Resources\RatingResource;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Author;
use App\Http\Resources\Critique;

class BookResource extends JsonResource
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
            'authors' => Author\BookResource::collection($this->authors),
            'genres' => GenreResource::collection($this->genres),
            'rating' => isset($userRating)
                ? new RatingResource($userRating)
                : ['avg' => $this->ratings()->avg('rating'), 'id' => null, 'rating' => null],
            'reviews' => ReviewResource::collection($this->reviews()->offset(0)->limit(3)->get()),
            'critiques' => Critique\BookResource::collection($this->critiques)
        ];
    }
}
