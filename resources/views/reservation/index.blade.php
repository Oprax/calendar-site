@extends('default')

@section('title', $title)

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li><li class="active">Réservations</li>
    </ul>

    @foreach($reservations as $reservation)
    <div>
        <h1>{{ $reservation->name }} {{ $reservation->forename }}</h1>
        <p>Du {{ $reservation->arrive_at }} au {{ $reservation->leave_at }} pour {{ $reservation->nb_people }} personne(s)</p>
        <p>
        @if(Auth::check())
            <a class="btn btn-primary" href="{{ route('reservation.edit', $reservation) }}">Modifier</a>
            {!! Form::open(['url' => route('reservation.destroy', $reservation), 'method' => 'DELETE']) !!}
              <button type="submit" class="btn btn-danger">Supprimer</button>
            {!! Form::close() !!}
        @else
            <a class="btn btn-primary" href="{{ route('reservation.show', $reservation) }}">Voir</a>
        @endif
        </p>
    </div>
    @endforeach
@endsection