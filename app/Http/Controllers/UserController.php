<?php

namespace App\Http\Controllers;

use App\Models\ItemCategories;
use App\Models\Items;
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

    public function createPo() {
        $user = Auth::user();
        $loadedStore = session('loadedStoreId') ?? false;
        $items = Items::where('stores_id', $loadedStore->id)->get();
        return view('purchase-orders.create', ['user' => $user, 'loadedStore'=>$loadedStore, 'items'=>$items]);

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

    public function viewItemsManagement() {
        $categories = ItemCategories::where('store_id', session('loadedStoreId')->id)->get();
        return view('items.items_management', ['categories'=>$categories]);
    }
}
