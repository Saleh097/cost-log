<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Group;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CostsMangementController extends Controller{
    public function addCost(Request $request){ //inserts a new cost to a group
        $groupId = $request->groupId;
        if(Gate::denies('add_cost', $groupId)) //checks if user is joined to group
            return "you cannot add cost to this group";
        $newCost = new Cost();
        $newCost->description = $request->costDescription;
        $newCost->group_id = $groupId;
        $newCost->user_id = Auth::id();
        $newCost->cost_amount = $request->costAmount;
        $newCost->save();
        return Redirect::back(); //TODO replace by returning message
    }

    public function ignoreCost(Request $request){ //alias to delete a cost (show it low opacity and do not include on calculations
        $costToDelete = Cost::where('group_id', $request->groupId)->where('user_id', Auth::id())->where('cost_amount',
            $request->costAmount)->first(); //i know it has logical bug (another cost maybe ignored)
        if(!is_null($costToDelete)){
            $costToDelete->is_ignored = 1;
            $costToDelete->save();
        }
        return "cost ignored!";
    }

    private function listSpentCostsForCurrentMonth(int $groupId){ //lists spent costs in a  group for individuals
        $group = Group::find($groupId); //TODO add filtering by user and sum row at bottom
        $currentMonthBeginning = today()->format('y-m') . '-00';
        $currentMonthEnding = today()->format('y-m') . '-30'; //TODO replace with a switch-case for 31 or 29 days monthes
        $membersIds = $group->members()->get()->isEmpty() ? $group->admin()->get("id") :
            $group->members()->get(['id'])->merge($group->admin()->get("id"));//to fix error when members are null
        $thisMonthCosts = collect();
        foreach ($membersIds as $memberId){
            $memberId = $memberId->id;
            $temp = Cost::where('user_id',$memberId)->where('group_id', $groupId)->where('costs.created_at','<',
                $currentMonthEnding)->where('costs.created_at','>', $currentMonthBeginning)->join('users', 'costs.user_id', '=',
                'users.id')->get(['name', 'cost_amount', 'costs.created_at', 'description']);
            foreach ($temp as $t){
                $thisMonthCosts->push($t);
            }
        }
        return $thisMonthCosts;
    }

    private function listSpentCostsForLastMonth(int $groupId){ //lists spent costs in a  group for individuals
        $group = Group::find($groupId); //TODO add filtering by user and sum row at bottom
        $lastMonth = (int) today()->format('m') - 1;
        $lastMonthBeginning = today()->format('y'). '-' . $lastMonth . '-00';
        $lastMonthEnding = today()->format('y'). '-' . $lastMonth . '-30'; //TODO replace with a switch-case for 31 or 29 days monthes
        $membersIds = $group->members()->get()->isEmpty() ? $group->admin()->get("id") :
            $group->members()->get(['id'])->merge($group->admin()->get("id"));//to fix error when members are null
        $lastMonthCosts = collect();
        foreach ($membersIds as $memberId){
            $memberId = $memberId->id;
            $temp = Cost::where('user_id',$memberId)->where('group_id', $groupId)->where('costs.created_at','<',
                $lastMonthEnding)->where('costs.created_at','>', $lastMonthBeginning)->join('users', 'costs.user_id', '=',
                'users.id')->get(['name', 'cost_amount', 'costs.created_at', 'description']);
            foreach ($temp as $t){
                $lastMonthCosts->push($t);
            }
        }
        return $lastMonthCosts;
    }

    private function listSpentCostsForCurrentYear(int $groupId){ //lists spent costs in a  group for individuals
        $group = Group::find($groupId); //TODO add filtering by user and sum row at bottom
        $currentYearBeginning = today()->format('y') . '-01-00';
        $currentYearEnding = today()->format('y') . '-12-30'; //TODO replace with a switch-case for 31 or 29 days monthes
        $membersIds = $group->members()->get()->isEmpty() ? $group->admin()->get("id") :
            $group->members()->get(['id'])->merge($group->admin()->get("id"));//to fix error when members are null
        $thisYearCosts = collect();
        foreach ($membersIds as $memberId){
            $memberId = $memberId->id;
            $temp = Cost::where('user_id',$memberId)->where('group_id', $groupId)->where('costs.created_at','<',
                $currentYearEnding)->where('costs.created_at','>', $currentYearBeginning)->join('users', 'costs.user_id', '=',
                'users.id')->get(['name', 'cost_amount', 'costs.created_at', 'description']);
            foreach ($temp as $t){
                $thisYearCosts->push($t);
            }
        }
        return $thisYearCosts;
    }

    private function getGroupsAllTimeCost(int $groupId){
        $group = Group::find($groupId); //TODO add filtering by user and sum row at bottom
        $membersIds = $group->members()->get()->isEmpty() ? $group->admin()->get("id") :
            $group->members()->get(['id'])->merge($group->admin()->get("id"));//to fix error when members are null
        $allCosts = collect();
        foreach ($membersIds as $memberId){
            $memberId = $memberId->id;
            $temp = Cost::where('user_id',$memberId)->where('group_id', $groupId)->join('users', 'costs.user_id', '=',
                'users.id')->get(['name', 'cost_amount', 'costs.created_at', 'description']);
            foreach ($temp as $t){
                $allCosts->push($t);
            }
        }
        return $allCosts;
    }

    public function calculateGroupsSpentCostsForSpecificMonth(Request $request){//calculates total spent costs of all group users
        $groupId = $request->groupId;
        $groupUsers = Group::find($groupId)->get()->members();
        $totalSpends = [];
        foreach ($groupUsers as $user){
            $currentMonthSpends = Cost::where('user_id',$user->id)->where('group_id',$groupId)->where(
                'is_ignored',0)->sum('cost_amount');
            $totalSpends[$user->name] = $currentMonthSpends; //TODO add unique constraint to name
        }
        return $totalSpends;
    }

    public function showGroupDetails(Request $request){
        if (Gate::denies('add_cost', $request->groupId)) //check user is joined to group (this gate checks same thing)
            return "access denied";
        $group = Group::find($request->groupId);
        $members = ($group->members()->get())->merge($group->admin()->get());
        $timeline = $request->time;
        $costs = strcmp($timeline,'current month')==0 ? $this->listSpentCostsForCurrentMonth($request->groupId) :
            (strcmp($timeline,'last month')==0 ? $this->listSpentCostsForLastMonth($request->groupId) :
            (strcmp($timeline,'this year')==0 ? $this->listSpentCostsForCurrentYear($request->groupId) :
            (strcmp($timeline,'all time')==0 ? $this->getGroupsAllTimeCost($request->groupId) :
            $this->listSpentCostsForCurrentMonth($request->groupId)))); //specific month uses different mechanism
        return view('ajaxLoads.GroupDetails', ["group"=>$group, 'members' => $members, 'costs' => $costs]);
    }
}