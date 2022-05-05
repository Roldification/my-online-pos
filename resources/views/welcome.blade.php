@extends('layouts.appview')

<div>
    @section('title')
        weh?    
    @endsection

    <div class="mt-8">
        @section('content')
            @if (count($user->stores()->get())===0)
                <example-component
                csrf-token='@csrf'
                user='{{json_encode($user)}}'
                >
                    
                </example-component>
            @else
                <div class="bg-red-200">
                    sdf
                </div>
            @endif
        @endsection
    </div>
    
</div>