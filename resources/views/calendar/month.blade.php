@extends('default')

@section('title', $year.' &bull; '.$monthLitt)

<?php
$dt_previous = \Carbon\Carbon::createFromDate($year, $month, 8)->subMonth();
$dt_next = \Carbon\Carbon::createFromDate($year, $month, 8)->addMonth();
?>

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li>
        <li><a href="{{ route('calendar.main', ['year' => $year]) }}">{{ $year }}</a> <span class="divider">/</span></li>
        <li class="active">{{ $monthLitt }}</li>
    </ul>

    <div class="text-center">
        <h1>{{ $monthLitt }}</h1>
        {!! $table !!}
    </div>

    <ul class="pager">
        <li><a href="{{ route('calendar.main', ['year' => $dt_previous->year, 'month' => $dt_previous->month]) }}">&larr; Précédent</a></li>
        <li><a href="{{ route('calendar.main', ['year' => $dt_next->year, 'month' => $dt_next->month]) }}">Suivant &rarr;</a></li>
    </ul>
@endsection