<?php

namespace App\Repositories\UserRepositories;

use App\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use DataTables;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
	protected $model;

 	public function __construct(User $user)
    {
        $this->model = $user;
    }

	public function allUsers()
	{
		return User::paginate(10);
		// return User::all();
		// return DataTables::of(User::query())->make(true);
	}

	public function updateUser(Request $request, User $user)
	{
		return User::where('id', $user->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);
	}
}

?>
