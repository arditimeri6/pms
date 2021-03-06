<?php

namespace App\Policies;

use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return (($user->id == $task->user_id) || ($user->hasRole('admin')));
    }

    public function delete(User $user, Task $task)
    {
        return (($user->id == $task->user_id) || ($user->hasRole('admin')));
    }

    public function addUser(User $user, Task $task)
    {
        return ($user->id == $task->user_id);
    }
}