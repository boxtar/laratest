<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';
    
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['name', 'profile_link', 'avatar', 'group_type_id'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function members(){
		return $this->belongsToMany('App\User')->withPivot('role_id')->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function type()
	{
		return $this->belongsTo(GroupType::class, 'group_type_id');
	}
}
