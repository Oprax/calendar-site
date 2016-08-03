@extends('default')

@section('title', $title)

@section('css')
    <link href="{{ route('welcome') }}/static/css/app.css" rel=stylesheet>
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a></li><li class="active">Réservations</li>
    </ul>

    <filter root="{{ route('welcome') }}" :auth="{{ Auth::check() ? 'true' : 'false' }}"></filter>

@endsection

@section('javascript')
    <script src="{{ route('welcome') }}/static/js/manifest.js"></script>
    <script src="{{ route('welcome') }}/static/js/vendor.js"></script>
    <script src="{{ route('welcome') }}/static/js/app.js"></script>
@endsection