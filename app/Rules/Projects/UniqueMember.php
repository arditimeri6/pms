<?php

namespace App\Rules\Projects;

use Illuminate\Contracts\Validation\Rule;
use App\ProjectUser;
use App\User;

class UniqueMember implements Rule
{
    protected $msg = 'The user is already a member.';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where('email', request()->email)->first();

        if ($user)
        {
            $member = ProjectUser::where('user_id', $user->id)->where('project_id', request()->project_id)->first();

            if($member)
            {
                return false;
            }
            return true;
        }
        $this->msg = 'User does not exists.';
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}