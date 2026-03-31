<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

use Illuminate\Auth\Access\Response;

use App\Services\UserService;

class SubjectPolicy
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
    public function view(User $user, Subject $subject): bool
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
    public function update(User $user, Subject $subject): bool
    {
        return $this->userService->is_admin($user) || $this->userService->is_teacher($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subject $subject): bool
    {
        return $this->userService->is_admin($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Subject $subject): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Subject $subject): bool
    {
        return false;
    }
}
