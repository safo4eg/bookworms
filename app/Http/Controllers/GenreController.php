<?php

namespace App\Http\Controllers;

use App\Http\Requests\Genre\StoreGenreRequest;
use App\Http\Requests\Genre\UpdateGenreRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Services\QueryString;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GenreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
        $this->authorizeResource(Genre::class, 'genre');
    }

    public function index(Request $request)
    {
        $qs = $request->collect();
        $books = $qs->isEmpty()
            ? Genre::all()
            : QueryString::handle($qs, Genre::class, 'genres');

        return GenreResource::collection($books);
    }

    public function store(StoreGenreRequest $request)
    {
        $payload = $request->validated();
        return new GenreResource(Genre::create($payload));
    }

    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());
        return new GenreResource($genre);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
