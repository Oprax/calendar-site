@extends('default')

@section('title', $year.' &bull; '.$monthLitt)

<?php
$dt_previous = \Carbon\Carbon::createFromDate($year, $month, 8)->subMonth();
$dt_next = \Carbon\Carbon::createFromDate($year, $month, 8)->addMonth();
?>

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('calendar.main', compact('year')) }}">{{ $year }}</a></li>
        <i class="right angle icon divider"></i>
        <div class="section active">{{ $monthLitt }}</div>
    </div>

    <h1 class="ui center aligned header">{{ $monthLitt }} {{ $year }}</h1>
    {!! $table !!}


    <div class="ui two item menu centered">
        <a class="item" href="{{ route('calendar.main', ['year' => $dt_previous->year, 'month' => $dt_previous->month]) }}"><i class="chevron left icon"></i> Précédent</a>
        <a class="item" href="{{ route('calendar.main', ['year' => $dt_next->year, 'month' => $dt_next->month]) }}">Suivant <i class="chevron right icon"></i></a>
    </div>
@endsection