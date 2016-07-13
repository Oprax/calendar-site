@extends('default')

@section('title', 'Réinitialisation')

@section('content')
    <div>
        <div class="text-center">
            <h1>Reinitialisation du mot de passe</h1>
        </div>

        {!! Form::open(['url' => route('auth.email'), 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('email', "Email", ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::email('email', isset($email) ? $email : '', ['class' => 'form-control']) !!}
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
