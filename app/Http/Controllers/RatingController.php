<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Requests\Rating\UpdateRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Rating::class, 'rating');
    }
    public function store(StoreRatingRequest $request, Book $book)
    {
        $payload = $request->validated();
        $payload['book_id'] = $book->id;

        $rating = Rating::where('user_id', $payload['user_id'])
            ->where('book_id', $payload['book_id'])
            ->first();

        if($rating) {
            throw ValidationException::withMessages([
                'book_id' => 'The table entry has already been created, use the update method'
            ]);
        } else $rating = Rating::create($payload);
        return new RatingResource($rating);
    }
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $newRating = $request->validated()['rating'];
        $rating->update(['rating' => $newRating]);
        return new RatingResource($rating);
    }
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
