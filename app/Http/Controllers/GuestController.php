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
        return view('index', [
            'items' => Item::getAllPubliclySorted(),
            'categories' => Category::getAllPubliclySorted()
        ])->withTitle('main');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($id)
    {
        $category = Category::findOrFail($id);
        return view('index', [
            'items' => $category->items()->paginate(6),
            'categories' => Category::getAllPubliclySorted(),
            'current_category' => $category
        ]);
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
