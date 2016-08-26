@extends('default')

@section('title', $title)

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <div class="section active">Réservations</div>
    </div>

    <h1 class="ui center aligned header">Montesquieu-des-Albères</h1>

    <filter root="{{ route('welcome') }}" :auth="{{ Auth::check() ? 'true' : 'false' }}"></filter>
@endsection

@section('javascript')
    <script src="{{ route('welcome') }}/static/js/manifest.js"></script>
    <script src="{{ route('welcome') }}/static/js/vendor.js"></script>
    <script src="{{ route('welcome') }}/static/js/app.js"></script>
@endsection