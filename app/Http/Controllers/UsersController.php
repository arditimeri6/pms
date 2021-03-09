<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Users\UsersUpdateFormRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use DataTables;

class UsersController extends Controller
{
    protected $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->middleware(['role:admin']);
        $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->users->allUsers();
        // $users = DB::table('users')->paginate(10);
        return view('users.index', ['users' => $users]);
        // return view('users.index');
    }
    // public function getUsers()
    // {
    //     return DataTables::of(User::query())
    //     // ->editColumn('name', "<a href='{{ route('users.show',['id'=>$id]) }}' >{{$name}}</a>")
    //     ->make(true);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateFormRequest $request, User $user)
    {
        $user->syncRoles([$request->role]);

        $user->syncPermissions([$request->permissions]);

        $this->users->updateUser($request, $user);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
