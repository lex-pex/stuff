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

    /**
     * Get all rightly sorted for public browsing
     * Where clause sort by:
     * created_at, updated_at, user_id, status
     * And "LiFo" order by: ascending, descending
     * @param int $id - category id
     * @return mixed
     */
    public static function getAllPubliclySortedByCategory(int $id) {
        return self::getAllPubliclySorted($id);
    }

    /**
     * Get all rightly sorted for public browsing
     * Where clause sort by:
     * created_at, updated_at, user_id, status
     * Also order by: ascending, descending
     * @param int $category_id - optional: on Zero Return All
     * @return mixed
     */
    public static function getAllPubliclySorted(int $category_id = 0) {
        $order = 'asc';
        $sort_by = 'id';
        if($sc = session('sort_criteria')) {
            $order = trim($sc['order']);
            $sort_by = trim($sc['sort_by']);
        }
        // Break into the Administrative Sort
        $status_order = $sort_by == 'status' ? $order : 'desc';
        if($category_id)
            return self::where('status', '>', 0) // Below Zero is Invisible
            ->where('category_id', $category_id)
                ->orderBy('status', $status_order) // Administrative Sort
                ->orderBy($sort_by, $order)
                ->paginate(6);
        else
            return self::where('status', '>', 0) // Below Zero is Invisible
                ->orderBy('status', $status_order) // Administrative Sort
                ->orderBy($sort_by, $order)
                ->paginate(6);
    }

}



