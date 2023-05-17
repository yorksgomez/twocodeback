<?php

namespace App\Policies;

use App\Models\Code;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CodePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Code $code): bool
    {
        return $code->project->user_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Code $code): bool
    {
        return $user->id == $code->project->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Code $code): bool
    {   
        return $user->id == $code->project->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Code $code): bool
    {
        return $user->id == $code->project->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Code $code): bool
    {
        return $user->id == $code->project->user_id;
    }

}
