<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message', 'owner_id', 'target_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Return a list of tags associated with this post
     *
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->toArray();
    }

	/**
	 * A post can have one owner
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner(){
		return $this->belongsTo('App\User');
	}

    /**
     * Get the tags associated with the given post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

}
