<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupType extends Model
{
    protected $table = 'group_types';

    protected $fillable = ['name', 'label'];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
