<?php

namespace App\Http\Resources;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

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
            'authors' => $this->when(
                request()->route()->named(
                    'books.index',
                    'books.show',
                    'books.update',
                    'books.store'
                ),
                AuthorResource::collection($this->authors)
            ),
            'genres' => $this->when(
                request()->route()->named(
                    'books.index',
                    'books.show',
                    'books.store',
                    'books.update',
                ),
                GenreResource::collection($this->genres)
            ),

            'rating' => isset($userRating)
                ? new RatingResource($userRating)
                : ['avg' => $this->ratings()->avg('rating'), 'id' => null, 'rating' => null]
        ];
    }
}
