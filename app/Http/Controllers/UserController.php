<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
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
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->rolesAssignmentManaging($request, $user);
        $this->validate($request, $this->updateValidationRules($request, $user));
        $data = $request->except('_token', 'password');
        if($request->password) {
            $data['password'] = Hash::make($request['password']);
        }
        $user->fill($data);
        $user->save();
        return redirect(route('users.show', $user));
    }

    /**
     * Assign the roles according checkboxes on the form
     * @param Request $request -
     * @param User $user - edited user
     */
    private function rolesAssignmentManaging(Request $request, User $user) {
            // ___ Get Request Roles
        $requestRolesArray = $request->roles ? $request->roles : [];
            // ___ Get existed User's Roles Array
        $userRolesArray = $user->roles->toArray();
            // Get existed User's Roles as array of strings
        $userRoleNamesArray = [];
        for($i = 0; $i < count($userRolesArray); $i ++) {
            $userRoleNamesArray[] = $userRolesArray[$i]['role'];
        }
            // ___ Attach, Detach, or Leave Roles according matching Request and User Roles Arrays
            // Go through all roles
        $allRolesCollection = Role::all();
        foreach($allRolesCollection as $role) {
                // Add or Delete Role depending whether it exists in request
            if (in_array($role->role, $requestRolesArray)) {
                // Prevent Duplicating Record if it already has been set
                if (!in_array($role->role, $userRoleNamesArray)) {
                    $user->roles()->attach($role);
                }
                // Delete Role if it didn't checked on the form
            } else {
                $user->roles()->detach($role);
            }
        }
    }

    /**
     * Get Validation Rules Array for Update User
     * @param Request $request
     * @param User $user
     * @return array
     */
    private function updateValidationRules(Request $request, User $user) {
        $validateRules = [
            'name' => ['required', 'string', 'max:255']
        ];
        if($request->password) {
            $validateRules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        if($request->email !== $user->email) {
            $validateRules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }
        return $validateRules;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(Gate::denies('users', $user->id)) {
            return redirect('error_page')->with('message', 'There is no access to users');
        }
        if(count($user->roles)) {
            return redirect()->back()->withStatus(
                'Cannot Delete User with roles, need to delete user\'s (#'. $user->id .', '. $user->name .') roles first !'
            );
        }
        $user->delete();
        return redirect(route('users.index'))->with(['status' => 'User #' . $user->id . ' deleted successfully']);
    }
}










