<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('adminRights'))
        {
            $roles = Role::all();
            $users = User::all();
            //$users = DB::select('select * from `users`');
            return view('admin.users', ['users' => $users, 'roles' => $roles]);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Gate::allows('ownerRights'))
        {
            $roles = Role::all();
            return view('admin.edit', ['user' => $user, 'roles' => $roles]);
        } elseif (Gate::allows('adminRights'))
        {
            return redirect() -> route('users.index');
        } else {
            return redirect() -> route('home');
        }
    }

    public function update(Request $request, user $user)
    {
        $user -> roles() -> sync($request->roles);

        return redirect() -> route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user -> delete();
        return redirect() -> route('users.index');
    }
}
