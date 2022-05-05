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
    </style>
</head>
<body>
    <div id="app" style="height:100%;">
        <div class="columns" style="height: 100%; padding: 15px;">
            <div class="column is-2" style="background-color:white; height: 100%;">
                @if (Auth::check())
                <aside class="menu is-size-7">
                    <p class="menu-label">
                      General
                    </p>
                    <ul class="menu-list">
                      <li><a>Items Inventory</a></li>
                      <li><a>Customers</a></li>
                    </ul>
                    <p class="menu-label">
                      Administration
                    </p>
                    <ul class="menu-list">
                      <li><a>Team Settings</a></li>
                      <li>
                        <a class="is-active">Manage Your Team</a>
                        <ul>
                          <li><a>Members</a></li>
                          <li><a>Plugins</a></li>
                          <li><a>Add a member</a></li>
                        </ul>
                      </li>
                      <li><a>Invitations</a></li>
                      <li><a>Cloud Storage Environment Settings</a></li>
                      <li><a>Authentication</a></li>
                    </ul>
                    <p class="menu-label">
                      Transactions
                    </p>
                    <ul class="menu-list">
                      <li><a>Payments</a></li>
                      <li><a>Transfers</a></li>
                      <li><a>Balance</a></li>
                    </ul>
                  </aside>
                @endif
                
            </div>
            <div class="column">
                @yield('content')
            </div>
        </div>
    </div>
    

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>