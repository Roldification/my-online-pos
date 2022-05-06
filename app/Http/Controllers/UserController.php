<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function register() {
        return view('register');
    }

    public function dashboard() {
        $user = Auth::user();
        $loadedStore = session('loadedStoreId') ?? false;
        $stores = $user->stores()->get();
        // dd($loadedStore);
        return view('welcome', ['user' => $user, 'stores'=>$stores, 'loadedStore'=>$loadedStore]);
    }

    public function login() {
        return view('login');
    }

    public function store(Request $request) {
        $user = User::create([
            'name' => $request->input('fullname'),
            'email' => $request->input('emailaddress'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response($user);
    }

    public function processLogin(Request $request) {
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return redirect()->intended('/');
        } else {
            return back()->withInput();
        }
    }
}
