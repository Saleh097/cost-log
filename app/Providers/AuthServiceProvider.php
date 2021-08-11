<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroupPivot;
use App\Models\JoinRequest;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Collection;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        Gate::define('can_request_to_join', function (User $user, int $groupId){
            $checkNotRequestedBefore = JoinRequest::where("group_id",$groupId)->where("user_id",$user->id)->get();
            $checkNotAdminOfRequestedGroup = Group::where('id',$groupId)->where('admin_id',$user->id)->get();
            $checkNotjoinedBefore = UserGroupPivot::where("group_id",$groupId)->where("user_id",$user->id)->get();
            return $checkNotRequestedBefore->isEmpty() && $checkNotAdminOfRequestedGroup->isEmpty() && $checkNotjoinedBefore->isEmpty();
        });

        Gate::define('accept_join', function (User $user, Collection $ids){
            $groupId = $ids['groupId'];
            $userId = $ids['userId'];
            $requestedGroup = Group::find($groupId);
            return $requestedGroup->admin_id == $user->id && $user->id != $userId;
            //checks admin of requested group id is the authenticated user && an admin doesnt request to self created group
        });

        Gate::define('add_cost', function (User $user, int $groupId){ //checks user is joined to specific group
            $usersGroup = UserGroupPivot::where('user_id',$user->id)->where('group_id', $groupId)->get();
            $checkAdmin = Group::find($groupId)->admin_id == $user->id;
            return !$usersGroup->isEmpty() || $checkAdmin;
        });

        Gate::define('manage_group', function (User $user, int $groupId){
            $requestedGroup = Group::find($groupId);
            return $requestedGroup->admin_id == $user->id;
            //checks if the authenticated user admin of requested group id
        });
    }
}
