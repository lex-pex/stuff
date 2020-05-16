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
         * Main Category #1 by Default
         * Doesn't have any own items
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
    public function category($id)
    {
        /**
         * Main Category #1 by Default
         * Doesn't have any own items
         */
        if($id == 1) {
            return redirect('/');
        }
        $category = Category::findOrFail($id);
        return view('index', [
            'items' => $category->items()->paginate(6),
            'categories' => Category::getAllPubliclySorted(),
            'category' => $category
        ])->withTitle($category->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('items.show', [
            'item' => $item
        ]);
    }
}
