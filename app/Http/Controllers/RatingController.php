<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Requests\Rating\UpdateRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function store(StoreRatingRequest $request)
    {
        $payload = $request->validated();
        $rating = Rating::create($payload);
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
        //
    }
}
