@extends('default')

@section('title', 'Connexion')

@section('content')
    <div>
        <div class="text-center">
            <h1>Connexion</h1>
        </div>

        {!! Form::open(['url' => route('auth.login'), 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('email', "Email", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::email('email', isset($email) ? $email : '', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password', "Mot de passe", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('remember', "Se souvenir de moi", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::checkbox('remember', isset($remember) ? $remember : '', ['class' => 'form-control']) !!}
                </div>
            </div>

            <br>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {!! app('captcha')->display() !!}
                </div>
            </div>
            <br>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <a href="{{ route('auth.email') }}">Mot de passe oublié ?</a>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {!! Form::submit('Connexion', ['class' => 'btn btn-default', 'type' => 'submit']) !!}
                    {{-- <a class="btn btn-default" href="{{ route('auth.register') }}">S'inscrire</a> --}}
                </div>
            </div>

        {!! Form::close() !!}
    </div>
@endsection
