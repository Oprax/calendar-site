@extends('default')

@section('title', $title)

@section('css')
    <link href="{{ route('welcome') }}/static/css/app.94eac4015cbf8e123fa1e056bc4eacb3.css" rel=stylesheet>
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a></li><li class="active">Réservations</li>
    </ul>

    <filter root="{{ route('welcome') }}" :auth="true"></filter>

@endsection

@section('javascript')
    <script src="{{ route('welcome') }}/static/js/manifest.5010b044744a34f8cf31.js"></script>
    <script src="{{ route('welcome') }}/static/js/vendor.06e46ea2cf0b5d562da8.js"></script>
    <script src="{{ route('welcome') }}/static/js/app.8ebbb8b5165d596cd113.js"></script>
@endsection