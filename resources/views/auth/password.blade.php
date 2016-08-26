@extends('default')

@section('title', 'Réinitialisation')

@section('content')
    {!! Form::open(['url' => route('auth.email'), 'method' => 'POST', 'class' => 'ui form']) !!}
        <h1 class="ui dividing header">Reinitialisation du mot de passe</h1>

        <div class="field">
            {!! Form::label('email', "Email") !!}
            {!! Form::email('email', isset($email) ? $email : '') !!}
        </div>

        <div class="field">
            {!! Form::submit('Envoyer', ['class' => 'ui button', 'type' => 'submit']) !!}
        </div>

    {!! Form::close() !!}
@endsection
