<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentReplyRequest;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCommentRequest $request, Comment $comment)
    {
        $comment->body = $request->comment_body;
        $comment->user()->associate(Auth::user());
        $post = Post::find($request->post_id);
        $post->comments()->save($comment);

        return back();
    }

    /**
     * @param Request $request
     * @param Comment $commentReply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replyStore(StoreCommentReplyRequest $request, Comment $commentReply)
    {
        $commentReply->body = $request->comment_body;
        $commentReply->user()->associate(Auth::user());
        $commentReply->parent_id = $request->comment_id;
        $post = Post::find($request->post_id);

        $post->comments()->save($commentReply);

        return back();

    }
}
