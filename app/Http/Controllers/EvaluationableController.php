<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Critique;
use App\Models\Reply;
use App\Models\Review;
use Illuminate\Http\Request;

class EvaluationableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function reviewStore(Request $request, Review $review)
    {
        return 'reviews';
    }

    public function critiqueStore(Request $request, Critique $critique)
    {
        return 'critiques';
    }

    public function commentStore(Request $request, Comment $comment)
    {
        return 'comments';
    }

    public function replyStore(Request $request, Reply $reply)
    {
        return 'replies';
    }
}
