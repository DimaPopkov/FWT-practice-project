<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

use App\Services\UserService;

class UserPolicy
{
    protected $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }
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
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->userService->is_admin($user) || $this->userService->is_teacher($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($this->userService->is_student($user)) return $user->id === $model->id;

        if ($this->userService->is_admin($user)) {
            return $user->id !== $model->id 
                && $model->role !== User::ROLE_ADMIN 
                && $user->group_id === $model->group_id;
        }
        
        if ($this->userService->is_teacher($user)) {
            return $model->is_student 
                && $user->group_id === $model->group_id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $this->userService->is_admin($user) 
            && $model->role !== User::ROLE_ADMIN 
            && $user->group_id === $model->group_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
