<?php

namespace App\Providers;

use App\Models\Groups;
use App\Models\Modules;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * users.view
         * 
         * 1. Lấy danh sách module 
         */
        $moduleList = Modules::all();

        if ($moduleList->count() > 0) {
            foreach ($moduleList as $module) {
                Gate::define($module->name, function (User $user) use ($module) {
                    // $groups = Groups::where('id', $user->group_id)->first();
                    // $roleJson = $groups->permissions;

                    $roleJson = $user->group->permissions;

                    if (!empty($roleJson)) {
                        $roleArr = json_decode($roleJson, true);

                        $check = isRole($roleArr, $module->name);

                        return $check;
                    }

                    return false;
                });
            }
        }
    }
}