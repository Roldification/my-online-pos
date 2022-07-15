<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Name - @yield('title')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Styles -->


    <style>
        body {
          /*  font-family: 'Nunito', sans-serif; */
        }

        .message-header {
            padding-bottom: 0em;
        }

        .panel-body {
            background-color: rgb(255 255 255);
        }

        .bg-grid-slate-100 {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='%23f1f5f9'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e")
        }

        button,
        [type='button'],
        [type='reset'],
        [type='submit'] {
        -webkit-appearance: button; /* 1 */
        background-image: none; /* 2 */
        }
    </style>
</head>
<body>
    <div id="app" class="h-screen bg-slate-50">
        <div class="flex flex-row relative h-full bg-grid-slate-100 overflow-hidden">
            <!-- sidenav -->
            <div class="w-44 h-full bg-red-200">
                @if (session()->has('loadedStoreId'))
                  <a href="{{ url('/') }}">  <h5 class="text-center font-semibold">{{session('loadedStoreId')->name}}</h5> </a>
                @endif
                <ul>

                    <li class="cursor-pointer px-2">
                        <a href="{{ url('/manage-items') }}">Manage Items</a>    
                    </li>
                    <li class="cursor-pointer px-2">
                        <a href="{{ url('/create-po') }}">Purchase Orders</a>    
                    </li>
                </ul>
            </div>
            <!-- sidenav -->
            <div class="grow relative overflow-hidden">
                @yield('content')
            </div>
          
        </div>
    </div>
    

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>