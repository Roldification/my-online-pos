@extends('layouts.appview')


<div>
  @section('content')
      <div class="p-8 h-screen">
        <div class="panel border-2 rounded-md">
            <div class="panel-header bg-blue-600 rounded-t-md px-2 py-1 text-white font-semibold">
              {{$itemData->name}}
            </div>

            <div class="panel-body p-5">
                I am the body
            </div> 
        </div>
      </div>
  @endsection
</div>