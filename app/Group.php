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
	protected $fillable = ['owner_id', 'name', 'profile_link', 'type'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function owner(){
		return $this->belongsTo('App\User');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function members(){
		return $this->belongsToMany('App\User')->withPivot('permissions')->withTimestamps();
	}
}
