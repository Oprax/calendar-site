@extends('default')

@section('title', 'Réinitialisation')

@section('content')
    <div>
        <h1>Réinitialisation</h1>

        {!! Form::open(['url' => route('auth.reset'), 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', isset($email) ? $email : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', "Mot de passe") !!}
                {!! Form::password('password', isset($password) ? $password : null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', "Confirmation du mot de passe") !!}
                {!! Form::password('password_confirmation', isset($password_confirmation) ? $password_confirmation : null, ['class' => 'form-control']) !!}
            </div>

            {!! Form::button('Envoyer', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
        {!! Form::close() !!}
    </div>
@endsection
