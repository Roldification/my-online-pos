<?php

namespace App\Http\Controllers;

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
}
