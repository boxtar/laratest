<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupRole extends Model
{
    protected $table = 'group_roles';

    protected $fillable = ['name', 'label'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(GroupPermission::class, 'group_permission_role', 'role_id', 'permission_id');
    }

    /**
     * @param GroupPermission $permission
     * @return Model
     */
    public function givePermission(GroupPermission $permission)
    {
        return $this->permissions()->save($permission);
    }
}
