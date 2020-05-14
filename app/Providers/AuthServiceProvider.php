<?php

namespace App\Providers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function(User $user) {
            if(!$user) return false;
            foreach ($user->roles as $role)
                if($role->role == 'admin')
                    return true;
            return false;
        });

        Gate::define('categories', function(User $user) {
            if(!$user) return false;
            foreach ($user->roles as $role)
                if($role->role == 'admin')
                    return true;
            return false;
        });

        Gate::define('users', function(User $user, $id) {
            if(!$user) return false;
            if ($user->id == $id)
                return true;
            foreach ($user->roles as $role)
                if($role->role == 'admin')
                    return true;
            return false;
        });

        Gate::define('create_item', function(User $user) {
            if(!$user) return false;
            foreach ($user->roles as $role)
                if($role->role == 'admin')
                    return true;
            return false;
        });

        Gate::define('delete_item', function(User $user) {
            if(!$user) return false;
            foreach ($user->roles as $role)
                if($role->role == 'admin')
                    return true;
            return false;
        });

        Gate::define('edit_item', function(User $user) {
            if(!$user) return false;
            foreach ($user->roles as $role)
                if($role->role == 'admin' || $role->role == 'moderator')
                    return true;
            return false;
        });
    }
}
