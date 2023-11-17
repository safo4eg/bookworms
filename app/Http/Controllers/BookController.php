<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Services\QueryString;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        $qs = $request->collect();
        $books = $qs->isEmpty()
            ? Author::all()
            : QueryString::handle($qs, Book::class, 'books');

        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request)
    {
        $payload = $request->validated();
        unset($payload['image']);

        if(!$request->hasFile('image') OR !$request->file('image')->isValid()) {
            throw ValidationException::withMessages([
                'image' => 'Failed to load image'
            ]);
        }

        $image_path = $request->image->store('Book');
        $payload['image_url'] = Storage::url($image_path);
        $book = Book::create($payload);

        return new JsonResponse(new BookResource($book), Response::HTTP_CREATED);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $payload = $request->validated();
        unset($payload['image']);

        if($request->hasFile('image')) {
            if($request->file('image')->isValid()) {
                $last_image_url = $book->image_url;
                preg_match('#^.+\/storage\/(?<last_path>.+)$#', $last_image_url, $matches);
                Storage::delete($matches['last_path']);

                $image_path = $request->image->store('Book');
                $payload['image_url'] = Storage::url($image_path);
            } else {
                throw ValidationException::withMessages([
                    'image' => 'Failed to load image'
                ]);
            }
        }

        $book->update($payload);
        return new JsonResponse(new BookResource($book), Response::HTTP_OK);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
