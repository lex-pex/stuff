<?php

namespace App\Http\Controllers;

use App\Helpers\AliasProcessor;
use App\Helpers\ImageProcessor;
use App\Helpers\Validator;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class ItemController extends Controller
{
    /**
     * @var string Default path for storing image-files
     */
    private $imgFolder = 'img/items';

    /**
     * Set sort filters for this resource. Clause "where" sort by:
     * created_at, updated_at, user_id, status
     * And "LiFo" order by: ascending, descending
     * @return Redirect
     */
    public function sortFilter() {
        session()->put('sort_criteria', $_POST);
        $url = url()->previous();
        if(preg_match('~/category/~', $url)) {
            return redirect($url);
        }
        return redirect('/');
    }

    /**
     * Display a listing of the resource.
     * Browsing page of all users.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('admin')) {
            return redirect('error_page')->with(['message' => 'This page is for Admin only']);
        }
        if(request('hidden')) {
            $items = Item::where('status', '<=', 0)->orderBy('id', 'desc');
        } else {
            $items = Item::select('*')->orderBy('id', 'desc');
        }
        $items = $items->paginate(6);
        return view('items.index', [
            'items' => $items
        ])->withTitle('Hidden Items');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create_item'))
            return redirect('error_page')->with(['message' => 'There is no access to create item']);
        /**
         * If Adding by Current Category
         */
        if(!$category = request('cat'))
            $category = 0;
        return view('items.create', [
            'categories' => Category::all()->except(1), // except for Default Main
            'current_category' => $category,
            'users' => User::all(),
            'user' => Auth::user(),
        ])->withTitle('Create Item');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('create_item')) {
            return redirect('error_page')->with(['message' => 'There is no access to create item']);
        }
        $this->validate($request, Validator::itemStore($request));
        $data = $request->except('_token', 'image');
        $item = new Item();
        $item->fill($data);
        // Alias creating or processing the given one
        if(!$request->alias) {
            $name = $request->title;
            $alias = AliasProcessor::getAlias($name, $item);
            $item->alias = $alias;
        } else {
            $item->alias = AliasProcessor::getAlias($request->alias, $item);
        }
        // Set User_Id by Auth if it has no set by Admin
        if ($user_id = $request->user_id) {
            $item->user_id = $request->user()->id;
        }
        // Set the picture
        if ($file = $request->image) {
            ImageProcessor::imageSave($file, $item, $this->imgFolder);
        }
        $item->save();
        return redirect(route('item', $item->alias));
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\Item $item - db record
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        if(Gate::denies('edit_item')) {
            return redirect('error_page')->with('message', 'There is no access to update item');
        }
        /**
         * All categories except for Default Main Category
         */
        $categories = Category::all()->except(1);
        $users = User::all();

        return view('items.edit', [
            'item' => $item,
            'categories' => $categories,
            'users' => $users
        ])->withTitle('Edit Item #' . $item->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item $item - db record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if(Gate::denies('edit_item')) {
            return redirect('error_page')->with('message', 'There is no access to update item');
        }
        $this->validate($request, Validator::itemUpdate($request, $item));
        $data = $request->except('_token', 'alias', 'image', 'image_del');
        $item->fill($data);
        // Image delete or upload
        if($request->has('image_del')) {
            ImageProcessor::imageDelete($item->image);
            $item->image = '';
        } elseif ($file = $request->image) {
            ImageProcessor::imageSave($file, $item, $this->imgFolder);
        }
        $item->save();
        return redirect()->back()->with(['status' => 'Item updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item $item - db record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if(Gate::denies('delete_item')) {
            return redirect('error_page', 500)->with('message', 'There is no access to delete item');
        }
        ImageProcessor::imageDelete($item->image);
        $item->delete();
        return redirect(route('items.index'))->withStatus('Item ' . $item->id . ' has deleted');
    }
}


