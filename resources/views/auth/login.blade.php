@extends('default')

@section('title', 'Connexion')

@section('content')
    <div>
        <h1>Connexion</h1>

        {!! Form::open(['url' => route('auth.login'), 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', isset($email) ? $email : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', "Mot de passe") !!}
                {!! Form::password('password', isset($password) ? $password : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('remember', "Se souvenir de moi") !!}
                {!! Form::checkbox('remember', isset($remember) ? $remember : null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <a href="{{ route('auth.email') }}">Mot de passe oublié ?</a>
            </div>

            <div class="form-group">
                {!! Form::button('Connexion', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                <a class="btn btn-primary" href="{{ route('auth.register') }}">S'inscrire</a>
            </div>

        {!! Form::close() !!}
    </div>
@endsection