@extends('default')

@section('title', $title)


@section('css')
        <link href="{{ route('welcome') }}/static/css/datepicker/default.css" rel="stylesheet" />
        <link href="{{ route('welcome') }}/static/css/datepicker/default.date.css" rel="stylesheet" />
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a></li>
        <li><a href="{{ route('reservations.index') }}">Réservations</a></li>
        <li><a href="{{ route('reservations.show', ['id' => $reservation->id]) }}">N°{{ $reservation->id }}</a></li>
        <li class="active">Modification</li>
    </ul>
    <div>
        <h1>Réservation N°{{ $reservation->id }}</h1>
        {!! Form::open(['url' => route('reservations.update', $reservation), 'method' => 'PUT']) !!}

            <div class="form-group">
                {!! Form::label('name', "Nom") !!}
                {!! Form::text('name', $reservation->name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('forename', "Prénom") !!}
                {!! Form::text('forename', $reservation->forename, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', $reservation->email, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('nb_people', "Nombre de personne") !!}
                {!! Form::text('nb_people', $reservation->nb_people, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('arrive_at', "Date d'arrivée (à Montesquieu)") !!}
                {!! Form::text('arrive_at', $reservation->arrive_at, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('leave_at', "Date de départ (de Montesquieu)") !!}
                {!! Form::text('leave_at', $reservation->leave_at, ['class' => 'form-control']) !!}
            </div>

            {!! Form::button('Envoyer', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            
        {!! Form::close() !!}

        @if(!$reservation->is_valid)
        {!! Form::open(['url' => route('reservations.update', $reservation), 'method' => 'PUT']) !!}

            {!! Form::hidden('name', $reservation->name) !!}
            {!! Form::hidden('forename', $reservation->forename) !!}
            {!! Form::hidden('email', $reservation->email) !!}
            {!! Form::hidden('nb_people', $reservation->nb_people) !!}
            {!! Form::hidden('arrive_at', $reservation->arrive_at) !!}
            {!! Form::hidden('leave_at', $reservation->leave_at) !!}
            {!! Form::hidden('is_valid', true) !!}

            {!! Form::button('Valider la Réservation', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}

        {!! Form::close() !!}
        @endif

        <br>

        {!! Form::open(['url' => route('reservations.destroy', $reservation), 'method' => 'DELETE']) !!}
            {!! Form::button('Supprimer', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('javascript')
        <script src="{{ route('welcome') }}/static/js/datepicker/picker.js"></script>
        <script src="{{ route('welcome') }}/static/js/datepicker/picker.date.js"></script>
        <script src="{{ route('welcome') }}/static/js/datepicker/fr_FR.js"></script>
        <script type="text/javascript">
        var datepickerOption = {
            formatSubmit: 'dd/mm/yyyy',
            format: 'dd/mm/yyyy'
        };
        $('#arrive_at').pickadate(datepickerOption);
        $('#leave_at').pickadate(datepickerOption);
        </script>
@endsection