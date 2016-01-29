@extends('default')

@section('title', $title)

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li>
        <li><a href="{{ route('reservations.index') }}">Réservations</a> <span class="divider">/</span></li>
        <li class="active">N°{{ $reservation->id }}</li>
    </ul>
    <div>
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
            <span class="label label-info">Acceptée</span>
            @else
            <span class="label label-important">Refusée</span>
            @endif
        </p>
        @if(Auth::check())
        <p>
            <a class="btn btn-primary" href="{{ route('reservations.edit', $reservation) }}">
            Modifier
            </a>
            {!! Form::open(['url' => route('reservations.destroy', $reservation), 'method' => 'DELETE']) !!}
              <button type="submit" class="btn btn-danger">Supprimer</button>
            {!! Form::close() !!}
        </p>
        @endif
    </div>
@endsection