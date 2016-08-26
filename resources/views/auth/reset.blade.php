@extends('default')

@section('title', 'Réinitialisation')

@section('content')
    {!! Form::open(['url' => route('auth.reset'), 'method' => 'POST', 'class' => 'ui form']) !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <h1 class="ui dividing header">Reinitialisation</h1>

        <div class="field">
            {!! Form::label('email', "Email") !!}
            {!! Form::email('email', isset($email) ? $email : '') !!}
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
