<?php

namespace App\Traits;

use App\Group;
use App\GroupRole;
use App\Http\Requests\GroupRequest;

trait CanHaveGroups{
    /**
     * A User Can belong to many Groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(){
        return $this->belongsToMany('App\Group')->withPivot('role_id')->withTimestamps();
    }

    /**
     * Creates a Group and makes the Authenticated User the Administrator
     *
     * @param GroupRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createGroup(GroupRequest $request)
    {
        // As User is creating a new group, he/she should be the admin:
        $admin_role = GroupRole::whereName('admin')->first();

        // This line creates the group, populates the pivot table and returns new group:
        return $this->groups()->create($request->all(), ['role_id' => $admin_role->id]);
    }

    /**
     * Checks if a User has a given Role for a given Group
     *
     * @param $role
     * @param Group $group
     * @return mixed
     */
    public function hasGroupRole($role, Group $group)
    {
        if(is_string($role)){
            if($r = $this->groupRole($group)){
                return $r->name == $role;
            }
            return false;
        }
        elseif($role instanceof GroupRole){
            return false;
        }
        else{
            foreach($role as $r) {
                // Recursive call to simmer down to string checking
                if($this->hasGroupRole($r->name, $group))
                    return true;
            }
        }
        return false;
    }

    /**
     * Returns the Users Role for the given Group
     *
     * @param $group
     * @return mixed
     */
    public function groupRole(Group $group)
    {
        if($group = $this->groups()->find($group->id)){
            return GroupRole::find($group->pivot->role_id);
        }
        return false;
    }
}