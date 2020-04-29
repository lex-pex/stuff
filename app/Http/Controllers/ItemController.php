<?php

namespace App\Http\Controllers;

use App\Item;
use App\Category;
use App\User;
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
    private $folder = 'img/items';

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create_item')) {
            return redirect('error_page')->with(['message' => 'There is no access to create item']);
        }
        $action = 'Create Item';
        $categories = Category::all();
        $users = User::all();
        $user = Auth::user();
        return view('items.create', [
            'action' => $action,
            'categories' => $categories,
            'users' => $users,
            'user' => $user
        ]);
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
            'text' => 'required|min:50|max:512',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
     * @param  \App\Item $item - db record
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        if(Gate::denies('edit_item')) {
            return redirect('error_page')->with('message', 'There is no access to update item');
        }
        $action = 'Update Article';
        $categories = Category::all();
        $users = User::all();

        return view('items.edit', [
            'action' => $action,
            'item' => $item,
            'categories' => $categories,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item $item - db record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:128',
            'text' => 'required|min:50|max:2048',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:512'
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
        return redirect()->back()->with(['status' => 'Ad updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item $item - db record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if(Gate::denies('delete_item')) {
            return redirect('error_page')->with('message', 'There is no access to delete item');
        }
        $item->delete();
        return redirect('/');
    }

    // _________ Private File Helpers: _________

    private function imageSave(UploadedFile $file, Item $i) {
        if($path = $i->image)
            $this->imageDelete($path);
        $dateName = date('dmyHis');
        $name = $dateName . '.' . $file->getClientOriginalExtension();
        $file->move($this->folder, $name);
        $i->image = "/$this->folder/$name";
    }

    private function imageDelete(string $path) {
        File::delete(trim($path, '/'));
    }
}
