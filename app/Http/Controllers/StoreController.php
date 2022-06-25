<?php

namespace App\Http\Controllers;

use App\Models\ItemCategories;
use App\Models\Items;
use App\Models\ItemSubcategories;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function insertItem(Request $request) {

       Validator::make($request->all(), [
            'name'=>'required',
            'category'=>'required',
            'sub_category_id'=>'required',
            'min_uom'=>'required'
        ])->validate();


        // API routes have no fucking clue about shit in the backend.

        $itemAttributes = $request->item_attributes;
        $itemAttributes['uoms'] = [
            [
                'uom'=>$request->min_uom,
                'min_uom_count'=>1,
                'is_base'=>true
            ]
        ];

        $item = new Items;
        $item->name = $request->name;
        $item->item_subcategories_id = $request->sub_category_id;
        $item->stores_id = session('loadedStoreId')->id;
        $item->min_uom_name = $request->min_uom;
        $item->item_attributes = json_encode($itemAttributes);
        $item->save();

        return response([
            'status'=>'ok',
            'message'=>''
        ]);
    }

    public function getRecentItems(Request $request) {

        $items = Items::where('stores_id', session('loadedStoreId')->id)->orderBy('id', 'desc')->with('subcategories')->paginate(5);

        return response($items);
    }

    public function viewItem(Request $request) {
        $items = Items::firstWhere('id', $request->query('id'));
        
        return view('items.view', ['itemData'=>$items]);
    }
}
