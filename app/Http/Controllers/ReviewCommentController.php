<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ReviewCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Comment::class, 'comment');
    }

    public function index(Review $review)
    {
        return CommentResource::collection($review->comments);
    }

    public function store(StoreCommentRequest $request, Review $review)
    {
        $payload = $request->validated();
        $payload['user_id'] = $request->user()->id;
        $payload['commentable_id'] = $review->id;
        $payload['commentable_type'] = 'review';
        $comment = Comment::create($payload);
        return new CommentResource($comment);
    }
}
