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

    /**
     * Get all rightly sorted for public browsing
     * @return mixed
     */
    public static function getAllPubliclySorted() {
        return self::where('status', '>', 0)->orderBy('status', 'desc')->orderBy('id', 'desc')->get();
    }

    /**
     * Get all rightly sorted for admin browsing
     * @return mixed
     */
    public static function getAllAdmin() {
        return self::orderBy('status', 'desc')->orderBy('id', 'desc')->get();
    }
}













