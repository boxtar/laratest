<?php

namespace App;

use App\Http\Requests\GroupRequest;

trait CanHaveGroups{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(){
        return $this->belongsToMany('App\Group')->withPivot('role_id')->withTimestamps();
    }

    /**
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
     * @param $role
     * @param Group $group
     * @return mixed
     */
    public function hasGroupRole($role, Group $group)
    {
        if(is_string($role)){
            return $this->groupRole($group)->name == $role;
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
     * @param $group
     * @return mixed
     */
    public function groupRole($group)
    {
        $role = $this->groups()->findOrFail($group->id)->pivot->role_id;
        return GroupRole::find($role);
    }
}