<?php

namespace App\Http\Controllers;

use App\User;
use App\profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    public function index()
    {
        return view('users.index')->with('users' , User::all());
    }


    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit(User $user)
    {
        $profile = $user->profile;
        return view('users.profile' , ['user' => $user , 'profile' => $profile]);
    }


    public function update(Request $request,User $user)
    {
        $profile = $user->profile;
        $data = $request->all();
        if($request->hasFile('picture')){
            $picture = $request->picture->store('profilePicture' , 'public');
            $data['picture'] = $picture;
        }

        $profile->update($data);
        return redirect()->route('users.index');
    }


    public function destroy($id)
    {
        $user = User::withTrashed()->where('id' , $id)->first();
        if($user->trashed()){
            $user->forceDelete();
            session()->flash('success' , 'The User Removed Successfully ');
        }else{
            $user->delete();
            session()->flash('success' , 'The User Trashed Successfully ');
        }
        return redirect()->route('users.index');

    }

    public function trashed(){
        $trashed = User::onlyTrashed()->get();
        return view('users.index')->with('users' , $trashed);
    }

    public function restore($id){
        $post = User::withTrashed()->where('id' , $id)->restore();
        session()->flash('success' , 'The User Restored Successfully ');
        return redirect()->route('users.index');
    }

    public function makeAdmin(User $user)
    {
        $user->role = 'admin';
        $user->save();
        return redirect()->route('users.index');
    }
}
