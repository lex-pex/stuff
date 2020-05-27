<?php

namespace App\Http\Controllers;

use App\Helpers\AliasProcessor;
use App\Helpers\ImageProcessor;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        $data = $request->except('_token', 'alias', 'image');
        $validationRules = [
            'name' => 'required|min:3|max:128',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        // Validate Description if it's given
        if($request->description) {
            $validationRules['description'] = 'required|min:10|max:1024';
        } else {
            $data['description'] = '';
        }
        // Validate Alias if it's given
        if($request->alias) {
            $validationRules['alias'] = 'min:2|max:256';
        }
        $this->validate($request, $validationRules);
        $category = new Category();

        // Alias creating or processing the given one
        if(!$request->alias) {
            $name = $request->name;
            $alias = AliasProcessor::getAlias($name, $category);
            $category->alias = $alias;
        } else {
            $category->alias = AliasProcessor::getAliasUnique($request->alias, $category);
        }

        $category->fill($data);
        if ($file = $request->image) {
            ImageProcessor::imageSave($file, $category, $this->imgFolder);
        }

        $category->save();
        return redirect(route('categories.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Category $category)
    {
        if(Gate::denies('categories')) {
            return redirect('error_page')->with('message', 'There is no access to categories');
        }
        return view('categories.edit', [
            'category' => $category
        ])->withTitle('Update Category #' . $category->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->except('_token', 'alias', 'image', 'image_del');
        $validationRules = [
            'name' => 'required|min:3|max:128',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|integer|min:0'
        ];
        if($request->description) {
            $validationRules['description'] = 'required|min:10|max:1024';
        } else {
            $data['description'] = '';
        }
        // Validate Alias if it was changed
        if($request->alias != $category->alias) {
            $validationRules['alias'] = 'min:2|max:256';
            $data['alias'] = AliasProcessor::getAlias($request->alias, $category);
        }
        $this->validate($request, $validationRules);
        $category->fill($data);
        if($request->has('image_del')) {
            ImageProcessor::imageDelete($category->image);
            $category->image = '';
        } elseif ($file = $request->image) {
            ImageProcessor::imageSave($file, $category, $this->imgFolder);
        }
        $category->save();
        return redirect(route('categories.index'))->with(['status' => 'Category #' . $category->id . ' updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Category $category)
    {
        /**
         * Except for Default Main Category
         */
        if($category->id == 1 || Gate::denies('categories')) {
            return redirect('error_page')->with('message', 'There is no access to categories');
        }
        ImageProcessor::imageDelete($category->image);
        $category->delete();
        return redirect(route('categories.index'))->with(['status' => 'Category #' . $category->id . ' deleted successfully']);
    }

}






