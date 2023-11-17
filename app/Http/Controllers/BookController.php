<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Services\QueryString;
use Illuminate\Http\Request;

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
        //
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    public function destroy(Book $book)
    {
        //
    }
}
