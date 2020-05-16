<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ItemController extends Controller
{
    /**
     * @var string Default path for storing image-files
     */
    private $imgFolder = 'img/items';

    public function index()
    {
        if(Gate::denies('delete_item')) {
            return redirect('error_page')->with(['message' => 'There is no access to edit item']);
        }
        $items = Item::where('status', '<=', 0)->paginate(6);
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
            $this->imageSave($file, $item);
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
            $this->imageDelete($item->image);
            $item->image = '';
        } elseif ($file = $request->image) {
            $this->imageSave($file, $item);
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
        $this->imageDelete($item->image);
        $item->delete();
        return redirect('/');
    }

    /**
     * Save uploaded image, set model's image path
     * @param UploadedFile $file
     * @param Model $i
     */
    private function imageSave(UploadedFile $file, Model $i) {
        if($path = $i->image)
            $this->imageDelete($path);
        $dateName = date('dmyHis');
        $name = $dateName . '.' . $file->getClientOriginalExtension();
        $file->move($this->imgFolder, $name);
        $i->image = '/'.$this->imgFolder.'/'.$name;
    }

    /**
     * Delete file by path
     * @param string $path
     */
    private function imageDelete(string $path) {
        if($path)
            File::delete(trim($path, '/'));
    }
}


