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
    public function items()
    {
        return $this->hasMany('App\Item', 'category_id', 'id');
    }
}
