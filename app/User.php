<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
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
	use Authenticatable, Authorizable, CanResetPassword, CanHaveGroups;

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
	 * Mutator for setting user name
	 *
	 * @param string $name
	 */									
	public function setNameAttribute($name){
		
		$bits = explode(' ', $name);
		
		foreach($bits as $k => $v)
			$bits[$k] = strtolower($v);
		
		$name = implode(' ', $bits);
		
		$this->attributes['name'] = $name;
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
	 * This is an unused Scope
	 * Not required anymore due to route model binding
	 *
	 * @param Illuminate\Database\Eloquent\Builder $query
	 * @param string $user
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function scopeFindUser($query, $user){
		return $query->whereProfileLink($user);
	}
										
	/**
	 * A user can have many articles
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function posts(){
		return $this->hasMany('App\Post', 'owner_id');
	}

	/**
	 * @return bool
     */
	public function isAdmin(){
		return false;
	}
}
