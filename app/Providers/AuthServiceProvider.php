<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    public function boot(GateContract $gate)
    {
        // $this->registerPolicies();

        $this->registerPolicies($gate);

        $gate->define('isSuperAdmin', function ($user) {
            return $user->admin_role == 'super_admin';
        });

        $gate->define('isAdmin', function ($user) {
            return $user->admin_role == 'admin';
        });

        $gate->define('isUser', function ($user) {
            return $user->admin_role == 'user';
        });
    }
}