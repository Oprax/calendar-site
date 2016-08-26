@extends('default')

@section('title', $title)

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('reservations.index') }}">Réservations</a>
        <i class="right angle icon divider"></i>
        <div class="section active">N°{{ $reservation->id }}</div>
    </div>

    <h1>Réservation N°{{ $reservation->id }}</h1>
    <p>
        De {{ $reservation->name }} {{ $reservation->forename }} pour {{ $reservation->nb_people }} personne(s).
    </p>
    <p>
        Du <a href="{{ route('calendar.main', ['year' => $reservation->arrive_at->year, 'month' => $reservation->arrive_at->month, 'day' => $reservation->arrive_at->day]) }}">{{ $reservation->arrive_at->format('d/m/Y') }}</a>
        au <a href="{{ route('calendar.main', ['year' => $reservation->leave_at->year, 'month' => $reservation->leave_at->month, 'day' => $reservation->leave_at->day]) }}">{{ $reservation->leave_at->format('d/m/Y') }}</a>.
    </p>
    <p>
        Statut :
        @if($reservation->is_valid)
        <span class="ui teal label"><i class="icon checkmark"></i>Acceptée</span>
        @else
        <span class="ui red label"><i class="icon remove"></i> Refusée</span>
        @endif
    </p>
    @if(Auth::check())
    <p>
        <a class="ui button primary" href="{{ route('reservations.edit', $reservation) }}">
        Modifier
        </a>
        {!! Form::open(['url' => route('reservations.destroy', $reservation), 'method' => 'DELETE']) !!}
          <button type="submit" class="ui button negative">Supprimer</button>
        {!! Form::close() !!}
    </p>
    @endif
@endsection