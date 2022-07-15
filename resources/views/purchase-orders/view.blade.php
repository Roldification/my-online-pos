@extends('layouts.appview')

@section('content')
<div class="p-2">
    <div class="">
        <div class="panel rounded-md drop-shadow-lg">
            <div class="panel-header bg-blue-600 rounded-t-md px-2 py-1 text-white font-semibold">
                Viewing Purchase Order ID: {{$po->po_number}}
            </div>

            <div class="panel-body p-5">
                <div class="flex flex-row space-x-5">
                    <div class="flex-grow w-1/2">
                        <view-purchase-order
                        :purchase-order="{{$po}}"
                        >

                        </view-purchase-order>
                    </div>
                    <div class="flex-grow w-1/2">
                        <span class="text-xs text-gray-400 font-bold">Author: Harold</span> <br/>
                        <span class="text-xs text-gray-400 font-bold">Date: 07/15/2022</span>
                        <el-tag>Tag 1</el-tag>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection