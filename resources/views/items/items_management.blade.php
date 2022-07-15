@extends('layouts.appview')

<div>
    @section('content')
    <div class="p-8 h-screen">
        <div class="flex flex-row space-x-5">
            <div class="w-1/4">
                <div class="panel rounded-md drop-shadow-lg">
                    <div class="panel-header bg-blue-600 rounded-t-md px-2 py-1 text-white font-semibold">
                        Add Item
                    </div>

                    <div class="panel-body p-5">
                        <create-item
                         store-id="{{session('loadedStoreId')->id}}"
                         item-categories="{{json_encode($categories)}}"
                        >
                            
                        </create-item>
                    </div> 
                </div>
            </div>
            <div class="grow">
                <div class="panel rounded-md drop-shadow-lg">
                    <div class="panel-header bg-blue-600 rounded-t-md px-2 py-1 text-white font-semibold">
                        Items List
                    </div>

                    <div class="panel-body p-5">
                        <items-list>
                        </items-list>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    @endsection
</div>
