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
        $payload = $request->collect()
            ->except('image')
            ->toArray();
        $book = Book::create($payload);

        if(!$request->hasFile('image') OR !$request->file('image')->isValid()) {
            throw ValidationException::withMessages([
                'image' => 'Failed to load image'
            ]);
        }

        $image_path = "Book/{$book->id}";
        $image_path = $request->image->store($image_path);
        $image_url = Storage::url($image_path);
        $book->update(['image_url' => $image_url]);

        return new JsonResponse(new BookResource($book), Response::HTTP_CREATED);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {

    }

    public function destroy(Book $book)
    {
        //
    }
}
