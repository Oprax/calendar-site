@extends('default')

@section('title', 'Réinitialisation')

@section('content')
    <div>
        <h1>Réinitialisation du mot de passe</h1>

        {!! Form::open(['url' => route('auth.email'), 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', isset($email) ? $email : null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::button('Envoyer', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection