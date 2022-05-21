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
            font-family: 'Nunito', sans-serif;
        }

        .message-header {
            padding-bottom: 0em;
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
    <div id="app" style="height:100%;">
        <div class="flex flex-row h-full">
          <!-- sidenav -->
          <div class="w-44 h-full bg-red-200">
            @if (session()->has('loadedStoreId'))
                <h5 class="text-center font-semibold">{{session('loadedStoreId')->name}}</h5>
            @endif
            <ul>
                <li class="cursor-pointer px-2">
                    Hello     
                </li>
                <li class="cursor-pointer px-2">
                    Manage Items     
                </li>
            </ul>
          </div>
          <!-- sidenav -->
          <div class="grow">
              @yield('content')
          </div>
        </div>
    </div>
    

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>