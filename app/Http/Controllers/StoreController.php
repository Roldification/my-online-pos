<?php

namespace App\Http\Controllers;

use App\Models\ItemCategories;
use App\Models\Items;
use App\Models\ItemSubcategories;
use App\Models\PurchaseOrders;
use App\Models\Store;
use App\Models\Warehouse;
use GuzzleHttp\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function GuzzleHttp\json_decode;

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

        // $itemAttributes = $request->item_attributes;
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
        $item->item_attributes = $itemAttributes;
        $item->save();

        return response([
            'status'=>'ok',
            'message'=>''
        ]);
    }

    public function updateItem (Request $request) {
        Validator::make($request->all(), [
            'id'=>'required',
            'name'=>'required',
            'category'=>'required',
            'sub_category_id'=>'required',
        ])->validate();

        $item = Items::find($request->id);
        $item->name = $request->name;
        $item->item_subcategories_id = $request->sub_category_id;
        $item->stores_id = session('loadedStoreId')->id;
        $item->save();

        return response([
            'status'=>'ok',
            'message'=>''
        ]);

    }

    public function updateUOMAttributes (Request $request) {
        $jsonChecker = Validator::make($request->all(), [
           // 'uoms' => 'json',
            'id' => 'required'
        ]);

        if ($jsonChecker->fails())
            return response([
                'status'=>'error',
                'message'=>$jsonChecker->errors()
            ], 500);
        
        $itemAttributes['uoms'] = $request->uoms;
        $item = Items::find($request->id);
        $item->item_attributes = $itemAttributes;
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
        // $items = Items::firstWhere('id', $request->query('id'))->with('subcategories');
        $item = Items::with(['subcategories.categories'])->where('id', $request->query('id'))->get()[0];
        $categories = ItemCategories::where('store_id', $item->stores_id)->get();
        $defaultSubcategories = ItemSubcategories::where('item_categories_id', $item->subcategories->categories->id)->get();
        
        return view('items.view', ['itemData'=>$item, 'categories'=>$categories, 'defaultSubcategories'=>$defaultSubcategories]);
    }

    public function viewPO(Request $request) {
        $po = PurchaseOrders::with([
            'purchaseOrderDetails',
            'purchaseOrderDetails.item:id,name,item_subcategories_id',
            'purchaseOrderDetails.item.subcategories:id,name,item_categories_id',
            'purchaseOrderDetails.item.subcategories.categories:id,name',
        ])->where('id', $request->query('id'))->first();


        if (!$po) {
            abort(404);
        } else {
           return view('purchase-orders.view', compact('po'));
        }
    }

    public function savePurchaseOrder (Request $request) {
        try {

            DB::beginTransaction();

            $poHeader = new PurchaseOrders();
            $poHeader->po_number = strtoupper(Str::random(10));
            $poHeader->status = 'DRAFT';
            $poHeader->users_id = Auth::user()->id;
            $poHeader->save();
            
            foreach ($request->poDetails as $row) {
                $poHeader->purchaseOrderDetails()->create([
                    'items_id' => $row['item'],
                    'quantity' => $row['quantity'],
                    'tentative_total_price' => $row['estimated_price'],
                    'item_properties' => '[]',
                    'users_id' => Auth::user()->id,
                    'uom' => $row['uom']
                ]);
            }

            DB::commit();

            return response([
                'status'=>'ok'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response([
                'message'=>$th->getMessage()
            ]);
        }
    }

    public function manageWarehouses () {

        return view('warehouses.index', []);
    }

    public function storeWarehouse (Request $request) {
        Validator::make($request->all(), [
            'name'=>'required'
        ])->validate();

        $wh = new Warehouse();
        $wh->name = $request->name;
        $wh->can_sell_from_here = $request->can_sell_from_here;
        $wh->save();
    }
}
