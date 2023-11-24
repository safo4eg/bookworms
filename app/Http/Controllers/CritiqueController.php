<?php

namespace App\Http\Controllers;

use App\Http\Requests\Critique\StoreCritiqueRequest;
use App\Http\Requests\Critique\UpdateCritiqueRequest;
use App\Http\Resources\Critique\CritiqueResource;
use App\Models\Book;
use App\Models\Critique;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CritiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    public function index(Book $book)
    {
        $critiques = $book->critiques;
        return CritiqueResource::collection($critiques);
    }

    public function store(StoreCritiqueRequest $request, Book $book)
    {
        $payload = $request->validated();
        $payload['user_id'] = $request->user()->id;
        $payload['book_id'] = $book->id;

        $critique = Critique::create($payload);
        return new CritiqueResource($critique);
    }
    public function show(Critique $critique)
    {
        return new CritiqueResource($critique);
    }
    public function update(UpdateCritiqueRequest $request, Critique $critique)
    {
        $payload = $request->validated();
        $critique->update($payload);
        return new CritiqueResource($critique);
    }
    public function destroy(Critique $critique)
    {
        $critique->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
