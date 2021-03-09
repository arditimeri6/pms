<?php

namespace App\Http\Controllers;
use App\Comment;
use App\Http\Requests\Comments\CommentSubmitFormRequest;
use App\Repositories\CommentRepositories\CommentRepositoryInterface;


class CommentsController extends Controller
{
    protected $comments;

    public function __construct(CommentRepositoryInterface $comments)
    {
        $this->comments = $comments;
    }

    public function store(CommentSubmitFormRequest $request)
    {
        $comment = $this->comments->addComment($request);

        if ($comment)
        {
            return back()->with('success', 'Comment added successfully');
        }
    }
}