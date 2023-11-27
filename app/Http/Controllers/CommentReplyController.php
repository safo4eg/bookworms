<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reply\StoreReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Comment;
use App\Models\Reply;

class CommentReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store');
        $this->authorizeResource(Reply::class, 'reply');
    }

    public function index(Comment $comment)
    {
        $replies = $comment->replies()->get()->toTree();
        return ReplyResource::collection($replies);
    }

    public function store(StoreReplyRequest $request, Comment $comment)
    {
        $replyId = $request->input('reply_id');
        $payload = [
            'text' => $request->input('text'),
            'user_id' => $request->user()->id,
            'comment_id' => $comment->id
        ];

        $reply = null;
        if(isset($replyId)) {
            $parentReply = Reply::where('id', $replyId)->first();
            $reply = Reply::create($payload, $parentReply);
        } else {
            $reply = Reply::create($payload);
        }

        return new ReplyResource($reply);
    }
}
