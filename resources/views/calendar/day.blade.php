@extends('default')

@section('title', $year.' &bull; '.$monthLitt.' &bull; '.$day)

<?php
use \Carbon\Carbon;

$dt = Carbon::createFromDate($year, $month, $day);
$dt_previous = Carbon::createFromDate($year, $month, $day)->subDay();
$dt_next = Carbon::createFromDate($year, $month, $day)->addDay();
?>

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li>
        <li><a href="{{ route('calendar.main', compact('year')) }}">{{ $year }}</a> <span class="divider">/</span></li>
        <li><a href="{{ route('calendar.main', compact('year', 'month')) }}">{{ $monthLitt }}</a> <span class="divider">/</span></li>
        <li class="active">{{ $day }}</li>
    </ul>

    <div class="row">
        <h1>Montesquieu-des-Albères</h1>

        <h2>{{ $day }} {{ $monthLitt }} {{ $year }}</h2>

        @forelse($isTaken as $reservation)
        <div class="hero-unit">
            <h3>Réservation N°{{ $reservation->id }}</h3>
            <p>
                De {{ $reservation->name }} {{ $reservation->forename }} pour {{ $reservation->nb_people }} personne(s).
            </p>
            <p>
                Du {{ $reservation->arrive_at->day }} {{ $months[$reservation->arrive_at->month - 1] }} {{ $reservation->arrive_at->year }}
                 au {{ $reservation->leave_at->day }} {{ $months[$reservation->leave_at->month - 1] }} {{ $reservation->leave_at->year }}.
            </p>
            <p>
                <a class="btn btn-primary" href="{{ route('reservations.show', $reservation) }}">Voir</a>
            </p>
        </div>
        @empty
        <div class="hero-unit">
           <p>Aucune réservation pour cette date !</p>
        </div>
        @endforelse

        @if($dt->isToday() or $dt->isFuture())
        <a class="btn btn-primary" href="{{ route('reservations.create') }}?arrive_at={{ $dt->toDateString() }}">
            Ajouter une réservation pour cette date
        </a>
        @endif

    </div>
    
    <ul class="pager">
        <li><a href="{{ route('calendar.main', ['year' => $dt_previous->year, 'month' => $dt_previous->month, 'day' => $dt_previous->day]) }}">&larr; Précédent</a></li>
        <li><a href="{{ route('calendar.main', ['year' => $dt_next->year, 'month' => $dt_next->month, 'day' => $dt_next->day]) }}">Suivant &rarr;</a></li>
    </ul>
@endsection
