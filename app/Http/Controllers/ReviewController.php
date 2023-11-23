<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index()
    {
        //
    }
    public function store(StoreReviewRequest $request, Book $book)
    {
        $payload = $request->validated();
        $payload['user_id'] = $request->user()->id;
        $payload['book_id'] = $book->id;

        $review = Review::where('user_id', $payload['user_id'])
            ->where('book_id', $payload['book_id'])
            ->first();

        if($review) {
            throw ValidationException::withMessages([
                'text' => 'You can only write one review'
            ]);
        } else {
            $review = Review::create($payload);
        }

        return new ReviewResource($review);
    }

    public function show(Review $review)
    {
        // показ со всеми комментами
    }
    public function update(UpdateReviewRequest $request, Review $review)
    {
        //
    }

    public function destroy(Review $review)
    {
        //
    }
}
