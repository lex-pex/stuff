<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     * status - field controlling the display and sort order,
     * where 0 is hidden and further numbers give the rating.
     * @var array
     */
    protected $fillable = ['title', 'text', 'image', 'category_id', 'user_id', 'status'];

    /**
     * Get the user that owns the article.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the category record associated with the article.
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}
