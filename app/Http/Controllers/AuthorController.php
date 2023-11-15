<?php

namespace App\Http\Controllers;

use App\Http\Requests\Author\StoreAndUpdateRequest;
use App\Http\Requests\Author\StoreRequest;
use App\Http\Requests\Author\UpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\QueryString;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $qs = $request->collect();
        if($qs->isEmpty()) $authors = Author::all();
        else $authors = QueryString::handle($qs, Author::class, 'authors');
        return AuthorResource::collection($authors);
    }

    public function store(StoreRequest $request)
    {
        $payload = $request->validated();
        $author = Author::create($payload);
        return new JsonResponse(new AuthorResource($author), Response::HTTP_CREATED);
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function update(UpdateRequest $request, Author $author)
    {
        $payload = $request->validated();
        $author->update($payload);
        return new JsonResponse(
            new AuthorResource($author),
            Response::HTTP_OK
        );
    }

    public function destroy(Author $author)
    {
        //
    }
}
