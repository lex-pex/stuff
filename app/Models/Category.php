<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     * status - field controlling the display and sort order,
     * where 0 is hidden and further numbers give the rating.
     * @var array
     */
    protected $fillable = ['name', 'image', 'description', 'status'];

    /**
     * Get the articles for the category.
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'category_id', 'id');
    }
}
