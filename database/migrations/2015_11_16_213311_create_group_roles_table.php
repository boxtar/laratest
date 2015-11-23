<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Roles Table
        Schema::create('group_roles', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->timestamps();
        });

        // Permissions Table
        Schema::create('group_permissions', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->timestamps();
        });

        // Roles and Permissions joining table
        Schema::create('group_permission_role', function(Blueprint $table){
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table->foreign('role_id')
                  ->references('id')
                  ->on('group_roles')
                  ->onDelete('cascade');

            $table->foreign('permission_id')
                  ->references('id')
                  ->on('group_permissions')
                  ->onDelete('cascade');

            $table->primary(['role_id', 'permission_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_permission_role');
        Schema::drop('group_permissions');
        Schema::drop('group_roles');
    }
}
