<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reply\StoreReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CommentReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store');
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
