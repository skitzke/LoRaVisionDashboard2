<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('settings',compact('user',$user));
    }

    public function update_avatar(Request $request){

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('avatars',$avatarName);

        $user->avatar = $avatarName;
        $user->save();
        redirect()->route('settings_index');
        return back()
            ->with('success','You have successfully upload image.');

    }

    public function update_name(Request $request)
    {
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(array('name' => $request->name));


        redirect()->route('settings_index');
        return back()
            ->with('success1','You have successfully updated your name.');
    }

    public function update_email(Request $request)
    {
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(array('email' => $request->email));


        redirect()->route('settings_index');
        return back()
            ->with('success1','You have successfully updated your E-mail.');
    }

    public function update_password(Request $request)
    {
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['password'=> Hash::make($request->password)]);


        redirect()->route('settings_index');
        return back()
            ->with('success1','You have successfully updated your password.');
    }

    public function delete_account()
    {
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->delete();

        Auth::logout();
          return  redirect()->route('login')->with('global', 'Your account has been deleted!');;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
