<?php

namespace App\Http\Controllers;

use App\Models\ItemCategories;
use App\Models\ItemSubcategories;
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

    public function getSubCategories(Request $request) {
        $categoryId = $request->query('id');

        $subCategories = ItemSubcategories::where('item_categories_id', $categoryId)->get();

        return response([
            'subcategories'=>$subCategories,
            'categoryId'=>$categoryId
        ]);
    }

    public function insertSubcategories(Request $request) {
        $subcategory = new ItemSubcategories;
        $subcategory->item_categories_id = $request->category_id;
        $subcategory->name = $request->subcategory_name;
        $subcategory->save();

        return response([
            'status'=>'ok',
            'message'=>$subcategory
        ]);
    }
}
