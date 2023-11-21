<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
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
            )
        ];
    }
}
