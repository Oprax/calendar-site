@extends('default')

@section('title', 'Page Introuvable')

@section('content')
    <h1>Page Introuvable</h1>
    <div class="row-fluid">
        <p>La page est introuvable !</p>
        <p><a class="btn btn-primary" href="{{ route('welcome') }}">Accueil</a></p>
    </div>
@endsection
