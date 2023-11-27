<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reply\StoreReplyRequest;
use App\Http\Requests\Reply\UpdateReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->authorizeResource(Reply::class, 'reply');
    }
    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        $reply->update($request->validated());
        return new ReplyResource($reply);
    }

    public function destroy(Reply $reply)
    {
        $reply->delete();
        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
