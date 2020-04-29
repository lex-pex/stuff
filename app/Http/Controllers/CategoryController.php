<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\UploadedFile;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('categories.index', [
            'categories' => $categories
        ])->withTitle('categories');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('categories')) {
            return redirect('error_page')->with(['message' => 'There is no access to categories']);
        }
        $action = 'Create Category';
        $categories = Category::all();

        return view('categories.create', [
            'action' => $action,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:128'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect(route('categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('categories')) {
            return redirect('error_page')->with('message', 'There is no access to categories');
        }
        $category = Category::findOrFail($id);
        return view('categories.edit', [
            'category' => $category
        ])->withTitle('Update Category #' . $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:128',
            'description' => 'required|min:50|max:1024',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:512'
        ]);
        $category = Category::findOrFail($id);
        $data = $request->except('_token', 'image', 'image_del');
        $category->fill($data);

        if($request->has('image_del')) {
            $this->imageDelete($category->image);
            $category->image = '';
        } elseif ($file = $request->image) {
            $this->imageSave($file, $category);
        }
        $category->save();

        return redirect(route('categories.index'))->with(['status' => 'Category ' . $id . ' updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('categories')) {
            return redirect('error_page')->with('message', 'There is no access to categories');
        }
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect(route('categories.index'))->with(['status' => 'Category #' . $id . ' deleted successfully']);
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






