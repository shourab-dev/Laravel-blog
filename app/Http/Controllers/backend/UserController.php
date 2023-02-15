<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function addUser()
    {
        $roles = Role::select('id', 'name')->get();
        $users = User::with('roles')->get();
        // dd();
        
        return view('backend.users.addUsers', compact('roles', 'users'));
    }

    public function storeUser(Request $request)
    {
        // dd($request->all());
        $user = new User();
        $user->name  =  $request->name;
        $user->email  =  $request->email;
        $user->password  = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);
        return back();
    }

    public function banUser($id)
    {
        $user = User::find($id);
        
        if($user->status == 1){
            $user->status = 0;
        } else{
            $user->status = 1;
        }
        $user->save();
        return back();
    }
}
