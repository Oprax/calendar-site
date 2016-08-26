@extends('default')

@section('title', 'Connexion')

@section('content')
    {!! Form::open(['url' => route('auth.login'), 'method' => 'POST', 'class' => 'ui form']) !!}
        <h1 class="ui dividing header">Connexion</h1>

        <div class="two fields">
            <div class="field">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', isset($email) ? $email : '') !!}
            </div>
            <div class="field">
                {!! Form::label('password', "Mot de passe") !!}
                {!! Form::password('password') !!}
            </div>
        </div>

        <div class="field">
            <div class="ui checkbox">
                {!! Form::checkbox('remember', isset($remember) ? $remember : '', ['class' => 'hidden']) !!}
                {!! Form::label('remember', "Se souvenir de moi") !!}
            </div>
        </div>

        <div class="field">
            {!! app('captcha')->display() !!}
        </div>

        <div class="field">
            <a href="{{ route('auth.email') }}">Mot de passe oublié ?</a>
        </div>

        <div class="field">
            {!! Form::submit('Connexion', ['class' => 'ui button', 'type' => 'submit']) !!}
            {{-- <a class="btn btn-default" href="{{ route('auth.register') }}">S'inscrire</a> --}}
        </div>

    {!! Form::close() !!}
@endsection
