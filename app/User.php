<?php

namespace App;

use App\Traits\CanHaveGroups;
use App\Traits\CanHaveImages;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class User
 * @package App
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword, SoftDeletes, CanHaveGroups, CanHaveImages;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'profile_link'];

	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

	/**
	 * Let Model know that Soft Deleting is activated
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];


	/**
	 * Mutator for setting user name
	 *
	 * @param string $name
	 */
	public function setNameAttribute($name){
		$this->attributes['name'] = strtolower($name);
	}

	/**
	 * Accessor for retrieving user name
	 *
	 * @param string $name
	 * @return string
	 */
	public function getNameAttribute($name){

		$bits = explode(' ', $name);

		foreach($bits as $k => $v)
			$bits[$k] = ucfirst($v);

		return $name = implode(' ', $bits);

	}

    /**
	 * Mutates changes to profile_link attribute
	 *
	 * @param string $value
	 */
	public function setProfileLinkAttribute($value){
		$this->attributes['profile_link'] = strtolower($value);
	}

	/**
	 * Password mutator: Ensures all passwords are encrypted
	 *
	 * @param $password
     */
	public function setPasswordAttribute($password){
		$this->attributes['password'] = bcrypt($password);
	}

	/**
	 * A user can have many posts
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function posts(){
		return $this->hasMany('App\Post', 'owner_id');
	}

	/*
	 * User storage paths for media storage
	 */
	public function storagePath() 	{ return userStoragePath($this); }
	public function imagePath() 	{ return userImagePath($this); }
	public function musicPath() 	{ return userMusicPath($this); }
	public function videoPath() 	{ return userVideoPath($this); }

	/**
	 * @return bool
     */
	public function isAdmin(){
		return false;
	}
}
