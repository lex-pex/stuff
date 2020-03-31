<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Get the articles for the category.
     */
    public function articles()
    {
        return $this->hasMany('App\Article', 'category_id', 'id');
    }
}
