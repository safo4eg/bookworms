<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Book;
use App\Models\Review;
use App\Services\QueryString;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Review::class, 'review');
    }

    public function index(Request $request, Book $book)
    {
        return ReviewResource::collection($book->reviews);
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
        return new ReviewResource($review);
    }
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $payload = $request->validated();
        $review->update($payload);
        return new ReviewResource($review);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
