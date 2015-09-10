@extends('default')

@section('title', $title)

<?php
if (Auth::check()) {
    $user = Auth::user();

    if(empty($forename)) {
        $forename = $user->name;
    }
    if(empty($email)) {
        $email = $user->email;
    }
}
?>

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li>
        <li><a href="{{ route('reservation.index') }}">Réservations</a> <span class="divider">/</span></li>
        <li class="active">Formulaire</li>
    </ul>

    <div>
        <h1>Formulaire de Réservation</h1>

        {!! Form::open(['url' => route('reservation.store'), 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('name', "Nom") !!}
                {!! Form::text('name', isset($name) ? $name : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('forename', "Prénom") !!}
                {!! Form::text('forename', isset($forename) ? $forename : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', isset($email) ? $email : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('nb_people', "Nombre de personne") !!}
                {!! Form::text('nb_people', isset($nb_people) ? $nb_people : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('arrive_at', "Date d'arrivée") !!}
                {!! Form::text('arrive_at', isset($arrive_at) ? $arrive_at : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('leave_at', "Date de départ") !!}
                {!! Form::text('leave_at', isset($leave_at) ? $leave_at : null, ['class' => 'form-control']) !!}
            </div>

            {!! Form::button('Envoyer', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
        {!! Form::close() !!}
    </div>
@endsection