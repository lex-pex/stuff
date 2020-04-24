<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * Browsing page of all users.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->sortBy('id');
        return view('users.index', [
            'users' => $users
        ])->withTitle('users');
    }

    /**
     * Display own users cabinet as the specified resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cabinet()
    {
        if(!Auth::check()) abort(404);
        return view('users.cabinet', [
            'user' => Auth::user()
        ])->withTitle('cabinet');
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('users', 0)) {
            return redirect('error_page')->with('message', 'There is no access to users');
        }
        return view('users.create')->withTitle('create User');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect(route('users.show', $user));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Gate::denies('users', 0)) {
            return redirect('error_page')->with('message', 'There is no access to users');
        }
        $roles = Role::all();

        $uroles = [];

        foreach ($user->roles as $role) {
            $uroles[] = $role->role;
        }

//        dump(in_array('admin', $uroles));
//        die();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'uroles' => $uroles
        ])->withTitle('create User');
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

        $data = $request->except('_token', '_method');

        dump($data);

        die();

        $validateRules = [
            'name' => ['required', 'string', 'max:255']
        ];
        if($request->password) {
            $validateRules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        if($request->email !== $user->email) {
            $validateRules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }
        $this->validate($request, $validateRules);
        $data = $request->except('_token', 'password');
        if($request->password) {
            $data['password'] = Hash::make($request['password']);
        }
        $user->fill($data);
        $user->save();
        return redirect(route('users.show', $user));
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
        $user->delete();
        return redirect(route('users.index'))->with(['status' => 'Category ' . $user->id . ' deleted successfully']);
    }
}
