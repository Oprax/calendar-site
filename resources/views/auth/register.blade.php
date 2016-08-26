@extends('default')

@section('title', 'Inscription')

@section('content')
    {!! Form::open(['url' => route('auth.register'), 'method' => 'POST', 'class' => 'ui form']) !!}
        <h1 class="ui dividing header">Inscription</h1>

        <div class="two fields">
            <div class="field">
                {!! Form::label('name', "Nom") !!}
                {!! Form::text('name', isset($name) ? $name : null) !!}
            </div>

            <div class="field">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', isset($email) ? $email : null) !!}
            </div>
        </div>

        <div class="two fields">
            <div class="field">
                {!! Form::label('password', "Mot de passe") !!}
                {!! Form::password('password') !!}
            </div>

            <div class="field">
                {!! Form::label('password_confirmation', "Confirmation du mot de passe") !!}
                {!! Form::password('password_confirmation') !!}
            </div>
        </div>

        <div class="field">
            {!! Form::submit('Envoyer', ['class' => 'ui button', 'type' => 'submit']) !!}
        </div>

    {!! Form::close() !!}
@endsection
