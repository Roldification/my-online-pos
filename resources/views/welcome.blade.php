@extends('layouts.appview')

<div>
    @section('title')
        weh?    
    @endsection

        @section('content')
            @if (count($stores)===0)
                <example-component
                csrf-token='@csrf'
                user='{{json_encode($user)}}'
                >
                    
                </example-component>
            @else
            <article class="message is-primary">
                <div class="message-header">
                  <p>Hi there, {{$loadedStore!==false ? $loadedStore->name : 'yow' }}</p>
                </div>
                <div class="message-body">
                  Below are your available store/s, Let's load it up!
                </div>
              </article>
                <div class="bg-red-200">
                    <div class="columns">
                        @foreach ($stores as $item)
                            <div class="column is-2">
                                <div class="card">
                                    <header class="card-header">
                                    {{$item->name}}
                                    </header>
                                    <footer class="card-footer">
                                        <a href="/load-store?storeId={{$item->id}}" class="card-footer-item">Load</a>
                                        <a href="#" class="card-footer-item">Edit</a>
                                        <a href="#" class="card-footer-item">Delete</a>
                                    </footer>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endsection

    
</div>