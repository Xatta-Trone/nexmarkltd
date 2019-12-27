<?php

namespace App\Providers;

use App\Model\Admin\Permission;
use Illuminate\Support\Facades\Gate;
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
    public function boot()
    {
        $this->registerPolicies();

        //

        foreach ($this->getPermissions() as $permission) {
            Gate::before(function ($admin) {
                if ($admin->email == 'xatta@admin.com') {
                    return true;
                }
            });

            Gate::define($permission->name, function ($admin) use ($permission) {
                return $admin->hasRole($permission->roles);
            });
        }
    }
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}
