<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
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
            'books' => $this->when(
                request()->route()->named(
                    'authors.index',
                    'authors.show',
                    'authors.store',
                    'authors.update'
                ),
                BookResource::collection($this->books)
            )
        ];
    }
}
