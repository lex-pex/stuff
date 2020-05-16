<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class CategoryController extends Controller
{
    /**
     * @var string Default path for storing image-files
     */
    private $imgFolder = 'img/categories';

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
        return view('categories.index', [
            'categories' => Category::getAllAdmin()
        ])->withTitle('Categories');
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
        return view('categories.create')->withTitle('Create Category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'image');
        $validationRules = [
            'name' => 'required|min:3|max:128',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        if($request->description) {
            $validationRules[] = ['description' => 'required|min:10|max:1024'];
        } else {
            $data['description'] = '';
        }
        $this->validate($request, $validationRules);
        $category = new Category();
        $category->fill($data);
        if ($file = $request->image) {
            $this->imageSave($file, $category);
        }
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
        $data = $request->except('_token', 'image', 'image_del');
        $validationRules = [
            'name' => 'required|min:3|max:128',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        if($request->description) {
            $validationRules[] = ['description' => 'required|min:10|max:1024'];
        } else {
            $data['description'] = '';
        }
        $this->validate($request, $validationRules);

        $category = Category::findOrFail($id);
        $category->fill($data);
        if($request->has('image_del')) {
            $this->imageDelete($category->image);
            $category->image = '';
        } elseif ($file = $request->image) {
            $this->imageSave($file, $category);
        }
        $category->save();
        return redirect(route('categories.index'))->with(['status' => 'Category #' . $id . ' updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * Except for Default Main Category
         */
        if($id == 1 || Gate::denies('categories')) {
            return redirect('error_page')->with('message', 'There is no access to categories');
        }
        $category = Category::findOrFail($id);
        $this->imageDelete($category->image);
        $category->delete();
        return redirect(route('categories.index'))->with(['status' => 'Category #' . $id . ' deleted successfully']);
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






