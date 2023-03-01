<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }


    public function googleRedirect()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $newUser  =  User::updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make(uniqid()),

            ]
        );
        $newUser->assignRole('subs');
        Auth::login($newUser);
        return redirect()->route('dashboard');
    }
    public function facebookLogin()
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function facebookRedirect()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        
        $newUser  =  User::updateOrCreate(
            [
                'email' => $user->email,
            ],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => Hash::make(uniqid()),

            ]
        );
        $newUser->assignRole('subs');
        Auth::login($newUser);
        return redirect()->route('dashboard');
    }
}
