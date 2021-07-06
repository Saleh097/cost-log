<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Group;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostsMangementController extends Controller{
    public function addCost(Request $request){ //inserts a new cost to a group
        $groupId = $request->groupId;
        if(Gate::denies('add_cost', $groupId)) //check if user is joined to group
            return "you cannot add cost to this group";
        $newCost = new Cost();
        $newCost->group_id = $groupId;
        $newCost->user_id = Auth::id();
        $newCost->cost_amount = $request->costAmount;
        $newCost->save();
        return "cost added sucessfully";
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

    public function listSpentCostsForCurrentMonth(Request $request){ //lists spent costs in a  group for individuals
        //TODO show members
        $groupId = $request->groupId; //TODO test this method
        $currentMonthBeginning = today()->format('y-m') . '-00';
        $currentMonthEnding = today()->format('y-m') . '-30'; //TODO replace with a switch-case for 31 or 29 days monthes
        $thisMonthCosts = Cost::where('user_id',Auth::id())->where('group_id', $groupId)->where('created_at','<',
            $currentMonthEnding)->where('created_at','>', $currentMonthBeginning)->get;
        return $thisMonthCosts;
    }

    public function calculateSpentCostsForSpecificMonth(){

    }

    public function calculateGroupsSpentCostsForSpecificMonth(Request $request){//calculates total spent costs of all group users
        $groupId = $request->groupId;
        $groupUsers = Group::find($groupId)->members();
        $totalSpends = [];
        foreach ($groupUsers as $user){
            $currentMonthSpends = Cost::where('user_id',$user->id)->where('group_id',$groupId)->where(
                'is_ignored',0)->sum('cost_amount');
            $totalSpends[$user->name] = $currentMonthSpends; //TODO add unique constraint to name
        }
        foreach ($totalSpends as $name=>$cost) {
            echo $name . " has spent " . $cost;
        }
    }

    public function showGroupDetails(Request $request){
        if (Gate::denies('add_cost', $request->groupId)) //check user is joined to group (this gate checks same thing
            return "access denied";
        $group = Group::find($request->groupId);
        $members = ($group->members()->get())->merge($group->admin()->get());
        return view('ajaxLoads.GroupDetails', ["group"=>$group, 'members' => $members]);
    }
}