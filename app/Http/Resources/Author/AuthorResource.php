<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Book;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'date_of_birth' => $this->date_of_birth,
            'date_of_death' => $this->date_of_death,
            'origin' => $this->origin,
            'desc' => $this->desc,
            'books' => Book\AuthorResource::collection($this->books)
        ];
    }
}
