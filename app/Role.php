<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role'];

    /**
     * The users that belong to the roles.
     */
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
