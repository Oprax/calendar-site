<!doctype html>
<html>
    <head>
        <title>Montesquieu • @yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{ route('welcome') }}/static/img/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <!-- Bootstrap -->
        <link href="{{ route('welcome') }}/static/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
        <link href="{{ route('welcome') }}/static/css/bootstrap-theme.min.css" rel="stylesheet">
        @yield('css')
    </head>
    <body>


    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="container-fluid"><div class="navbar-header"><a class="navbar-brand" href="{{ route('welcome') }}">Montesquieu</a></div>

                <p class="navbar-text pull-right">
                    @if(Auth::check())
                        {{ Auth::user()->name }} • <a href="{{ route('auth.logout') }}" class="navbar-link">Déconnexion</a>
                    @else
                        <a href="{{ route('auth.login') }}" class="navbar-link">Connexion</a>
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        @include('errors')
        @yield('content')
    </div>
    <script src="{{ route('welcome') }}/static/js/jquery.min.js"></script>
    <script src="{{ route('welcome') }}/static/js/bootstrap.min.js"></script>
    @yield('javascript')

    </body>
</html>