<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Intern;
use App\Models\Mentor;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class InternPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Intern $intern)
    {
        if($user->isRecruiter())
        {
            return true;
        }
        else
        {
            $mentor = Mentor::where('email', '=', $user->email)->first();
            return $mentor->groups->pluck('id')->contains($intern->group->id);
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isRecruiter();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Intern $intern)
    {
        return $user->isRecruiter();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Intern $intern)
    {
        return $user->isRecruiter();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Intern $intern)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Intern  $intern
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Intern $intern)
    {
        //
    }
}
