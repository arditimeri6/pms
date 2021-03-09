<?php 

namespace App\Repositories\CommentRepositories;

use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Repositories\CommentRepositories\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
	protected $model;
 	
 	public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

	public function addComment(Request $request)
	{
		return Comment::create([
            'body' => $request->input('body'),
            'url' => $request->input('url'),
            'commentable_type' => $request->input('commentable_type'),
            'commentable_id' => $request->input('commentable_id'),
            'user_id' => Auth::user()->id
        ]);
	}
}