<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->take(7)->get();
        $user = Auth::user();
        return view('home', [
            'user_name' => $user->name,
            'user_role' => $user->roles()->first()->role,
            'items' => $items
        ]);
    }
}
