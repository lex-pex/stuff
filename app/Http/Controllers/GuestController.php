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
        $items = Item::where('status', '>', 0)
            ->orderBy('status', 'desc')->orderBy('id', 'desc')->paginate(6);
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('index', [
            'items' => $items,
            'categories' => $categories
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
        $items = $category->items()->paginate(6);
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('index', [
            'items' => $items,
            'categories' => $categories,
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
