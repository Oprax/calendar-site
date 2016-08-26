@extends('default')

@section('title', $title)


@section('css')
        <link href="{{ route('welcome') }}/static/css/datepicker/default.css" rel="stylesheet" />
        <link href="{{ route('welcome') }}/static/css/datepicker/default.date.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('reservations.index') }}">Réservations</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('reservations.show', ['id' => $reservation->id]) }}">N°{{ $reservation->id }}</a>
        <i class="right angle icon divider"></i>
        <div class="section active">Modification</div>
    </div>
        {!! Form::open(['url' => route('reservations.update', $reservation), 'method' => 'PUT', 'class' => 'ui form']) !!}
            <h1 class="ui dividing header">Réservation N°{{ $reservation->id }}</h1>

            <div class="field">
                {!! Form::label('name', "Nom") !!}
                {!! Form::text('name', $reservation->name) !!}
            </div>
            <div class="field">
                {!! Form::label('forename', "Prénom") !!}
                {!! Form::text('forename', $reservation->forename) !!}
            </div>
            <div class="field">
                {!! Form::label('email', "Email") !!}
                {!! Form::email('email', $reservation->email) !!}
            </div>
            <div class="field">
                {!! Form::label('nb_people', "Nombre de personne") !!}
                {!! Form::text('nb_people', $reservation->nb_people) !!}
            </div>
            <div class="field">
                {!! Form::label('arrive_at', "Date d'arrivée (à Montesquieu)") !!}
                {!! Form::text('arrive_at', $reservation->arrive_at) !!}
            </div>
            <div class="field">
                {!! Form::label('leave_at', "Date de départ (de Montesquieu)") !!}
                {!! Form::text('leave_at', $reservation->leave_at) !!}
            </div>

            {!! Form::button('Envoyer', ['class' => 'ui button primary', 'type' => 'submit']) !!}
            
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

            {!! Form::button('Valider la Réservation', ['class' => 'ui button primary', 'type' => 'submit']) !!}

        {!! Form::close() !!}
        @endif

        <br>

    {!! Form::open(['url' => route('reservations.destroy', $reservation), 'method' => 'DELETE']) !!}
        {!! Form::button('Supprimer', ['class' => 'ui button negative', 'type' => 'submit']) !!}
    {!! Form::close() !!}
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