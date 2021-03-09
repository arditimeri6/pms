<?php 
namespace App\Repositories\CommentRepositories;

use Illuminate\Http\Request;

interface CommentRepositoryInterface 
{
	public function addComment(Request $request);
}