<?php

namespace App\Policies;

use App\Models\Mentor;
use App\Models\User;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class MentorPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Mentor $mentor)
    {
        if($user->isRecruiter())
        {
            return true;
        }
        else
        {
            return $user->email == $mentor->email;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createAssignmentReview(User $user, Mentor $mentor)
    {
        return $user->email == $mentor->email;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Mentor $mentor)
    {
        return $user->email == $mentor->email;
    }

    public function updateMentor(User $user, Mentor $mentor)
    {
        if($user->isRecruiter())
        {
            return true;
        }
        else
        {
            return $user->email == $mentor->email;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Mentor $mentor)
    {
        return $user->email == $mentor->email;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Mentor $mentor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Mentor  $mentor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Mentor $mentor)
    {
        //
    }
}
