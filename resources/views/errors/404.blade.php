@extends('default')

@section('title', 'Page Introuvable')

@section('content')
    <h1>Page Introuvable</h1>
    <div class="ui message">
        <p>La page est introuvable !</p>
        <p><a class="ui button primary" href="{{ route('welcome') }}">Accueil</a></p>
    </div>
@endsection
