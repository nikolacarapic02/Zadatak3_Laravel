<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Group;
use App\Models\Mentor;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Group $group)
    {
        if($user->isRecruiter())
        {
            return true;
        }
        else
        {
            $mentor = Mentor::where('email', '=', $user->email)->first();
            return $mentor->groups->pluck('id')->contains($group->id);
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Group $group)
    {
        return $user->isRecruiter();
    }

    public function activate(User $user, Group $group)
    {
        if($user->isRecruiter())
        {
            return false;
        }
        else
        {
            $mentor = Mentor::where('email', '=', $user->email)->first();
            return $mentor->groups->pluck('id')->contains($group->id);
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Group $group)
    {
        return $user->isRecruiter();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Group $group)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Group $group)
    {
        //
    }
}
