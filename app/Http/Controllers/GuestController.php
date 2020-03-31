<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(6);
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('index', [
            'articles' => $articles,
            'categories' => $categories
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
        $articles = $category->articles()->paginate(6);
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('index', [
            'articles' => $articles,
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
        $article = Article::findOrFail($id);
        return view('show', [
            'edit_access' => Gate::allows('edit_article'),
            'article' => $article
        ]);
    }
}
