<?php

namespace App\Providers;

use App\Models\User;

use App\Observers\UserObserver;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
            $canManage = ($user->checkRole(1) || $user->checkRole(2)) 
                && $user->group_id === $student->group_id;

            return $canManage ? Response::allow()
                : Response::deny('У вас нет прав для управления оценками этой группы.');
        });

        User::observe(UserObserver::class);
    }
}
