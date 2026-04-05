<?php

namespace App\Providers;

use App\Models\User;

use App\Services\UserService;

use App\Observers\UserObserver;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use Illuminate\Auth\Access\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-grades', function (User $user, $student) {
            $userService = app(UserService::class);

            $canManage = ($userService->checkRole($user, 1) || $userService->checkRole($user, 2)) 
                && $user->group_id === $student->group_id;

            return $canManage ? Response::allow()
                : Response::deny('У вас нет прав для управления оценками.');
        });

        User::observe(UserObserver::class);
    }
}
