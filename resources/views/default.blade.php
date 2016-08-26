<!doctype html>
<html>
    <head>
        <title>Montesquieu • @yield('title')</title>
        <link rel="icon" type="image/png" href="{{ route('welcome') }}/static/img/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link href="{{ route('welcome') }}/static/dist/semantic.min.css" rel="stylesheet">
        <style>
            /* 60px to make the container go all the way to the bottom of the topbar */
            body { padding-top: 60px; }
        </style>
        @yield('css')
    </head>
    <body>

    <div class="ui menu top fixed inverted">
        <a href="{{ route('welcome') }}" class="item header">Montesquieu</a>
        <div class="menu right">
            @if(Auth::check())
                <div class="item"><i class="icon user"></i>{{ Auth::user()->name }}</div>
                <a href="{{ route('auth.logout') }}" class="item">Déconnexion</a>
            @else
                <a href="{{ route('auth.login') }}" class="item">Connexion</a>
            @endif
        </div>
    </div>

    <div class="ui container">
        @include('errors')
        @yield('content')
    </div>
    <p>&nbsp;</p>
    <script src="{{ route('welcome') }}/static/js/jquery.min.js"></script>
    <script src="{{ route('welcome') }}/static/dist/semantic.min.js"></script>
    <script>
        (function($) {
            $('.message .close').on('click', function() {
                $(this).closest('.message')
                        .transition('fade');
            });
        })(jQuery);
    </script>
    @yield('javascript')
    </body>
</html>