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
        /*
         * Stub - mock main Category
         */
        $category = new \stdClass();
        $category->name = 'Main Page';
        $category->id = 0;
        $category->image = '/img/empty.jpg';
        $category->description = 'When people are doing a physical task, it\'s easy to assess how hard they are working.';

        return view('index', [
            'current_category' => $category,
            'items' => Item::getAllPubliclySorted(),
            'categories' => Category::getAllPubliclySorted()
        ]);
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
