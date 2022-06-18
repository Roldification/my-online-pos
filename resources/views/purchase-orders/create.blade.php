@extends('layouts.appview')

@section('content')
<div class="p-2">
    Create Purchase Order
    <div class="">
        <create-purchase-order :items="{{json_encode($items)}}">
        </create-purchase-order>
    </div>
</div>
@endsection