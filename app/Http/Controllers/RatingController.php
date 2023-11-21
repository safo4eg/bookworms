<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request)
    {
        $payload = $request->validated();
        $rating = Rating::create($payload);
        return new RatingResource($rating);
    }
    public function update(Request $request, Rating $rating)
    {
        //
    }
    public function destroy(Rating $rating)
    {
        //
    }
}
