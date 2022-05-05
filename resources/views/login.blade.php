@extends('layouts.appview')

@section('content')
<div class="p-8">
    <div class="card w-1/2 mx-auto">
        <div class="card-header">Login</div>

        @if ($errors->any())
            nag error 
        @endif
        <div class="card-body">
            @csrf
            
           <login
             csrf-token='@csrf'
             oldemail='{{old('email')}}'
             oldpassword='{{old('password')}}'
           >

           </login>
        </div>
    </div>
</div>
@endsection