<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display own users cabinet as the specified resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cabinet()
    {
        return view('users.cabinet', [
            'user' => Auth::user()
        ])->withTitle('cabinet');
    }

    /**
     * Display a listing of the resource.
     * Browsing page of all users.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $users = User::with('roles')->get();

        $users = User::all()->sortBy('id');

//        $user = $users->last();
//
//        $res = 'Role: ';
//
//        foreach ($user->roles()->get() as $role) {
//            $res .= $role->role . ', ';
//        }
//        die($res);
//
//        dump($user->roles()->first()->role);
//
//        die();

        return view('users.index', [
            'users' => $users
        ])->withTitle('users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dump('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dump('users.store = new User()');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.profile', [
            'user' => $user
        ])->withTitle('profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        dump('users.edit.' . $user->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        dump('update the user: ' . $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Gate::denies('users', $user->id)) {
            return redirect('error_page')->with('message', 'There is no access to users');
        }
        dump('destroy the user: ' . $user->id);
    }
}
