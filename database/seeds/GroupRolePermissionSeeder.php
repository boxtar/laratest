<?php

use App\GroupPermission;
use App\GroupRole;
use Illuminate\Database\Seeder;

class GroupRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_permission_role')->truncate();

        GroupPermission::truncate();

        GroupRole::truncate();

        $this->setupRolesAndPermissions();
    }

    /**
     *
     */
    private function setupRolesAndPermissions()
    {
        $this->createPermissions();

        $this->createRoles();

        $this->createRolePermissionRelations();
    }

    /**
     *
     */
    private function createPermissions()
    {
        $permissions = [
            'manage_members'=>'Manage Group Members',
            'manage_media'=>'Manage Group Media',
            'edit_details'=>'Edit Group Details'
        ];

        foreach($permissions as $name => $label){
            GroupPermission::create([
                'name' => $name,
                'label' => $label
            ]);
        }
    }

    /**
     *
     */
    private function createRoles()
    {
        $roles = [
            'admin' => 'Group Administrator',
            'editor' => 'Group Editor',
            'member' => 'Group Member'
        ];

        foreach($roles as $name => $label){
            GroupRole::create([
                'name' => $name,
                'label' => $label
            ]);
        }
    }

    /**
     *
     */
    private function createRolePermissionRelations()
    {
        $roles = GroupRole::all();
        $permissions = GroupPermission::all();

        foreach($roles as $role){

            if($role->name == 'admin'){

                foreach($permissions as $permission){

                    $role->givePermission($permission);

                }

            }
            elseif($role->name == 'editor'){

                foreach($permissions as $permission){

                    if($permission->name == 'manage_media' || $permission->name == 'edit_details')
                        $role->givePermission($permission);

                }

            }
        }
    }
}
