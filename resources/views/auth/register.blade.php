@extends('default')

@section('title', 'Inscription')

@section('content')
    <div>
        <div class="text-center">
            <h1>Inscription</h1>
        </div>

        {!! Form::open(['url' => route('auth.register'), 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('name', "Nom", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', isset($name) ? $name : null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', "Email", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::email('email', isset($email) ? $email : null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password', "Mot de passe", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', "Confirmation du mot de passe", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {!! Form::submit('Envoyer', ['class' => 'btn btn-default', 'type' => 'submit']) !!}
                </div>
            </div>

        {!! Form::close() !!}
    </div>
@endsection
