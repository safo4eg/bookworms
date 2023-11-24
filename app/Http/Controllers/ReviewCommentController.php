<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Review;

class ReviewCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index()
    {
        //
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

    public function show(Comment $comment)
    {
        //
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        //
    }
}
