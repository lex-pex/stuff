<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        $user = Auth::user();
        return view('categories.index', [
            'user_name' => $user->name,
            'user_role' => $user->roles()->first()->role,
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
        $action = 'Update Category';
        $category = Category::findOrFail($id);
        return view('categories.edit', [
            'action' => $action,
            'category' => $category
        ]);
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
        ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
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

        dd('destroy category( ' . $id . ')');

        if(Gate::denies('categories')) {
            return redirect('error_page')->with('message', 'There is no access to categories');
        }
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect(route('categories.index'))->with(['status' => 'Category ' . $id . ' deleted successfully']);;
    }
}






