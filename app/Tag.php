<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Fillable fields for a Tag
     *
     * @var array
     */
    protected $fillable=[
        'name'
    ];
    /**
     * Get the articles associated with the given tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
