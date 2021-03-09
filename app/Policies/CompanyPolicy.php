<?php

namespace App\Policies;

use App\User;
use App\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can update the Company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $Company
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        return (($user->id == $company->user_id) || ($user->hasRole('admin')));
    }

    public function delete(User $user, Company $company)
    {
         return (($user->id == $company->user_id) || ($user->hasRole('admin')));
    }
}