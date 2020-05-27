<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Main Category #1 by Default. Doesn't have any own items
         */
        $category = Category::findOrFail(1);
        return view('index', [
            'category' => $category,
            'items' => Item::getAllPubliclySorted(),
            'categories' => Category::getAllPubliclySorted()
        ])->withTitle($category->name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($alias)
    {
        if(!$category = Category::where('alias', $alias)->first()) abort(404);
        /**
         * Main Category #1 by Default
         * Doesn't have any own items
         */
        if($category->id == 1) {
            return redirect('/');
        }
        return view('index', [
            'items' => Item::getAllPubliclySortedByCategory($category->id),
            'categories' => Category::getAllPubliclySorted(),
            'category' => $category
        ])->withTitle($category->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $alias
     * @return \Illuminate\Http\Response
     */
    public function item($alias)
    {
        if(!$item = Item::where('alias', $alias)->first()) abort(404);
        return view('items.show', [
            'item' => $item
        ]);
    }
}








