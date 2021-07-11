<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\JoinRequest;
use App\Models\UserGroupPivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class GroupsController extends Controller
{
    public function createGroup(Request $request){ // TODO add remove group
        $groupName = $request->groupName;
        $newGroup = new Group();
        $newGroup->group_name = $groupName;
        $newGroup->admin_id = Auth::id();
        $newGroup->save();
        return "Group created successfully"; //replace by returning error message to view
    }

    public function requestJoinGroup(Request $request){
        $groupId = $request->groupId;
        if (Gate::denies('can_request_to_join', $groupId))
            return "failure";  //this join request is already sent
        $joinRequst = new JoinRequest();
        $joinRequst->user_id = Auth::id();
        $joinRequst->group_id = $groupId;
        $joinRequst->save();
        return "success";
    }

    public function acceptJoinRequest($groupId, $userId){ //TODO maybe add remove member
        if(!Gate::allows('accept_join', collect(['groupId'=>$groupId , 'userId' => $userId])))
            return "Access denied B**h!";
        $joinRequest = JoinRequest::where('user_id',$userId)->where('group_id', $groupId)->first();
        $newJoin = new UserGroupPivot();
        $newJoin->user_id = $userId;
        $newJoin->group_id = $groupId;
        $newJoin->save();
        DB::table('join_requests')->where('user_id', $userId)->where('group_id',$groupId)->delete();
        return "user joined to group successfully";
    }

    public function declineJoinRequest($groupId, $userId){
        if(!Gate::allows('accept_join', collect(['groupId'=>$groupId , 'userId' => $userId])))
            return "Access denied B**h!"; //same priviledges as accept_join nedded
        DB::table('join_requests')->where('user_id', $userId)->where('group_id',$groupId)->delete();
        return "users join request declined"; //TODO send notificatioon to user when declined(or accepted)
    }

    public function showJoinToGroup ($groupName=null){
        if(!is_null($groupName)){
            $groups = Group::where('group_name',$groupName)->where('admin_id', '<>', Auth::id())->join('users', 'groups.admin_id'
                , '=', 'users.id')->get(['groups.id as id', 'group_name','name as admin_name']);
            $groups = $groups->isEmpty() ? 0 : $groups;
            return view('ajaxLoads.joinGroup',['groups'=> $groups]);
        }
        return view('ajaxLoads.joinGroup');
    }

    public function showjoinedGroups(){
        $groups = Auth::user()->groups()->join('users', 'groups.admin_id', '=', 'users.id')->get(
            ['groups.id as id', 'group_name','name as admin_name']);
        $adminGroups = Group::where('admin_id','=', Auth::id())->join('users', 'groups.admin_id', '=', 'users.id')->get([
            'groups.id as id', 'group_name','name as admin_name']);
        $groups = $groups->merge($adminGroups);
        return view('ajaxLoads.joinedGroups', ['groups' => $groups]);
    }

    public function showManageMyGroups(){
        $groups = Auth::user()->groupAdmin()->get();
        $waitingJoins = collect();
        foreach ($groups as $group){
            $joinWaiters = $group->waitingJoiners()->get(['id','name']);
            foreach ($joinWaiters as $joinWaiter)
                $waitingJoins->push(collect(['user_id'=>$joinWaiter->id,'group_id' => $joinWaiter->pivot->group_id ,
                    'name'=>$joinWaiter->name, 'group_name'=>$group->group_name]));
        }
        return view('ajaxLoads.myGroups', ['groups' => $groups, 'waitingJoins'=>$waitingJoins]);
    }
}
