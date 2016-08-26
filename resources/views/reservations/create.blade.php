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

@section('css')
        <link href="{{ route('welcome') }}/static/css/datepicker/default.css" rel="stylesheet" />
        <link href="{{ route('welcome') }}/static/css/datepicker/default.date.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('reservations.index') }}">Réservations</a></li>
        <i class="right angle icon divider"></i>
        <div class="section active">Formulaire</div>
    </div>


    {!! Form::open(['url' => route('reservations.store'), 'method' => 'POST', 'class' => 'ui form']) !!}
        <h1 class="ui dividing header">Formulaire de Réservation</h1>
        <div class="field">
            {!! Form::label('name', "Nom") !!}
            {!! Form::text('name', isset($name) ? $name : null) !!}
        </div>
        <div class="field">
            {!! Form::label('forename', "Prénom") !!}
            {!! Form::text('forename', isset($forename) ? $forename : null) !!}
        </div>
        <div class="field">
            {!! Form::label('email', "Email") !!}
            {!! Form::email('email', isset($email) ? $email : null) !!}
        </div>
        <div class="field">
            {!! Form::label('nb_people', "Nombre de personne") !!}
            {!! Form::text('nb_people', isset($nb_people) ? $nb_people : null) !!}
        </div>
        <div class="field">
            {!! Form::label('arrive_at', "Date d'arrivée (à Montesquieu)") !!}
            {!! Form::text('arrive_at', isset($arrive_at) ? $arrive_at : null) !!}
        </div>
        <div class="field">
            {!! Form::label('leave_at', "Date de départ (de Montesquieu)") !!}
            {!! Form::text('leave_at', isset($leave_at) ? $leave_at : null) !!}
        </div>

        <div class="field">
            {!! app('captcha')->display() !!}
        </div>

        {!! Form::button('Envoyer', ['class' => 'ui button primary', 'type' => 'submit']) !!}
    {!! Form::close() !!}
@endsection

@section('javascript')
        <script src="{{ route('welcome') }}/static/js/datepicker/picker.js"></script>
        <script src="{{ route('welcome') }}/static/js/datepicker/picker.date.js"></script>
        <script src="{{ route('welcome') }}/static/js/datepicker/fr_FR.js"></script>
        <script type="text/javascript">
        var datepickerOption = {
            formatSubmit: 'yyyy-mm-dd',
            format: 'yyyy-mm-dd'
        };
        $('#arrive_at').pickadate(datepickerOption);
        $('#leave_at').pickadate(datepickerOption);
        </script>
@endsection