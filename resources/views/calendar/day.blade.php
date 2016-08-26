@extends('default')

@section('title', $year.' &bull; '.$monthLitt.' &bull; '.$day)

<?php
use \Carbon\Carbon;

$dt = Carbon::createFromDate($year, $month, $day);
$dt_previous = Carbon::createFromDate($year, $month, $day)->subDay();
$dt_next = Carbon::createFromDate($year, $month, $day)->addDay();
?>

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('calendar.main', compact('year')) }}">{{ $year }}</a></li>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('calendar.main', compact('year', 'month')) }}">{{ $monthLitt }}</a>
        <i class="right angle icon divider"></i>
        <div class="section active">{{ $day }}</div>
    </div>

    <div class="row">
        <h1>Montesquieu-des-Albères</h1>

        <h2>{{ $day }} {{ $monthLitt }} {{ $year }}</h2>

        @forelse($isTaken as $reservation)
        <div class="ui message">
            <div class="header">Réservation N°{{ $reservation->id }}</div>
            <p>
                De {{ $reservation->name }} {{ $reservation->forename }} pour {{ $reservation->nb_people }} personne(s).
            </p>
            <p>
                Du {{ $reservation->arrive_at->day }} {{ $months[$reservation->arrive_at->month - 1] }} {{ $reservation->arrive_at->year }}
                 au {{ $reservation->leave_at->day }} {{ $months[$reservation->leave_at->month - 1] }} {{ $reservation->leave_at->year }}.
            </p>
            <p>
                @if(Auth::check())
                    {!! Form::open(['url' => route('reservations.destroy', $reservation), 'method' => 'DELETE']) !!}
                    <a class="ui button primary" href="{{ route('reservations.edit', $reservation) }}">
                        Modifier
                    </a>
                    <button type="submit" class="ui button negative">Supprimer</button>
                    {!! Form::close() !!}
                @else
                    <a class="ui button" href="{{ route('reservations.show', $reservation) }}">Voir</a>
                @endif
            </p>
        </div>
        @empty
        <div class="ui message">
           Aucune réservation pour cette date !
        </div>
        @endforelse

        @if($dt->isToday() or $dt->isFuture())
        <a class="ui button primary" href="{{ route('reservations.create') }}?arrive_at={{ $dt->toDateString() }}">
            Ajouter une réservation pour cette date
        </a>
        @endif

    </div>
    
    <div class="ui two item menu centered">
        <a class="item" href="{{ route('calendar.main', ['year' => $dt_previous->year, 'month' => $dt_previous->month, 'day' => $dt_previous->day]) }}"><i class="chevron left icon"></i> Précédent</a>
        <a class="item" href="{{ route('calendar.main', ['year' => $dt_next->year, 'month' => $dt_next->month, 'day' => $dt_next->day]) }}">Suivant <i class="chevron right icon"></i></a>
    </div>
@endsection
