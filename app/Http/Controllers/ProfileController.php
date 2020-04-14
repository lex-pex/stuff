<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{
    /**
     * Show the user start profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', [
            'user' => $user
        ]);
    }

    public function index() {
        $users = User::all()->sortBy('id');
        return view('users.index', [
            'users' => $users
        ]);
    }

}
