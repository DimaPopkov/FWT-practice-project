<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

use Illuminate\Auth\Access\Response;

use App\Services\UserService;

class GroupPolicy
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
    public function view(User $user, Group $group): bool
    {
        if ($this->userService->is_student($user)) return $user->group_id === $group->id;
        
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->userService->is_admin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group): bool
    {
        return $this->userService->is_admin($user) && $user->group_id === $group->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Group $group): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Group $group): bool
    {
        return false;
    }
}
