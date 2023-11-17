<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\StoreAndUpdateRequest;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\QueryString;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
        $this->authorizeResource(Author::class, 'author');
    }
    public function index(Request $request)
    {
        $qs = $request->collect();
        $authors = $qs->isEmpty()
            ? Author::all()
            : QueryString::handle($qs, Author::class, 'authors');

        return AuthorResource::collection($authors);
    }

    public function store(StoreAuthorRequest $request)
    {
        $payload = $request->validated();
        $author = Author::create($payload);
        return new JsonResponse(new AuthorResource($author), Response::HTTP_CREATED);
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $payload = $request->validated();
        $author->update($payload);
        return new JsonResponse(new AuthorResource($author), Response::HTTP_OK);
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
