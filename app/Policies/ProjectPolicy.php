<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\User  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return (($user->id == $project->user_id) || ($user->hasRole('admin')));
    }

    public function delete(User $user, Post $project)
    {
        return (($user->id == $project->user_id) || ($user->hasRole('admin')));
    }

    public function addUser(User $user, Project $project)
    {
        return ($user->id == $project->user_id);
    }
}