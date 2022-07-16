@extends('layouts.appview')

@section('content')
<div class="p-2">
    <div class="panel rounded-md drop-shadow-lg">
        <div class="panel-header bg-blue-600 rounded-t-md px-2 py-1 text-white font-semibold">
            Warehouse Management
        </div>

        <div class="panel-body p-5">
            <create-warehouses>

            </create-warehouses>
        </div> 
    </div>
</div>
@endsection