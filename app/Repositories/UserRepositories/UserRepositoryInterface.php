<?php 
namespace App\Repositories\UserRepositories;

use Illuminate\Http\Request;
use App\User;


interface UserRepositoryInterface 
{
	public function allUsers();

	public function updateUser(Request $request, User $user);
}

?>