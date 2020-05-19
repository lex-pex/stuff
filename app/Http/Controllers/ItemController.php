<?php

namespace App\Http\Controllers;

use App\Helpers\ImageProcessor;
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
            $items = Item::where('status', '<=', 0);
        } else {
            $items = Item::select('*');
        }
        $items = $items->paginate(6);
        return view('items.index', [
            'items' => $items
        ])->withTitle('Hidden Items');
    }

    /**
     * Set sort filters for the resource. Where clause sort by:
     * created_at, updated_at, user_id, status
     * And "LiFo" order by: ascending, descending
     * @return Redirect
     */
    public function sortFilter() {
        // Write into session
        session()->put('sort_criteria', $_POST);
        // Build the patch for redirect
        $url = url()->previous();
        $path = '/';
        if(preg_match('~/category/~', $url)) {
            $path = $url;
        }
        return redirect($path);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create_item')) {
            return redirect('error_page')->with(['message' => 'There is no access to create item']);
        }
        /**
         * All categories except for Default Main Category
         */
        $categories = Category::all()->except(1);
        $users = User::all();
        $user = Auth::user();
        return view('items.create', [
            'categories' => $categories,
            'users' => $users,
            'user' => $user
        ])->withTitle('Create Item');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:128',
            'text' => 'required|min:50|max:2048',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ]);
        $data = $request->except('_token', 'image');
        $item = new Item();
        $item->fill($data);
        if ($user_id = $request->user_id) {
            $item->user_id = $request->user()->id;
        }
        if ($file = $request->image) {
            ImageProcessor::imageSave($file, $item, $this->imgFolder);
        }
        $item->save();
        return redirect(route('item_show', $item->id));
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
        $this->validate($request, [
            'title' => 'required|min:3|max:128',
            'text' => 'required|min:50|max:2048',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ]);
        $data = $request->except('_token', 'image', 'image_del');
        $item->fill($data);
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
            return redirect('error_page')->with('message', 'There is no access to delete item');
        }
        ImageProcessor::imageDelete($item->image);
        $item->delete();
        return redirect('/');
    }
}


