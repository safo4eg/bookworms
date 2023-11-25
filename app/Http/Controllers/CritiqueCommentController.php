<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Models\Critique;

class CritiqueCommentController extends Controller
{

    public function index(Critique $critique)
    {

    }

    public function store(StoreCommentRequest $request, Critique $critique)
    {
        $payload = $request->validated();
        $payload['user_id'] = $request->user()->id;
        $payload['commentable_id'] = $critique->id;
        $payload['commentable_type'] = 'critique';
        $comment = Comment::create($payload);
        return new CommentResource($comment);
    }

}
