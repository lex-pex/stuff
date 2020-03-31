<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'text', 'image', 'category_id', 'user_id'];

    /**
     * Get the user that owns the article.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }

    /**
     * Get the category record associated with the article.
     */
    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }
}
