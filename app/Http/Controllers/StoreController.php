<?php

namespace App\Http\Controllers;

use App\Models\ItemCategories;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    
    public function store(Request $request) {
        
        $data = $request->validate([
            'name'=>'required|max:100',
            'slug'=>'required|max:10'
        ]);

        $data['user_id'] = Auth::user()->id;
     
        $store  = Store::create($data);
        return back();
    }

    public function loadStore(Request $request) {
        //$request->session()->put('loadedStoreId', 2);

        $store = Store::find($request->query('storeId'));
        session(['loadedStoreId'=>$store]);
        return back();
    }

    public function insertCategories(Request $request) {
        $category = new ItemCategories;
        $category->store_id = $request->id;
        $category->name = $request->name;
        $category->save();

            return response([
                'status'=>'ok',
                'message'=>$category
            ]);
    }
}
