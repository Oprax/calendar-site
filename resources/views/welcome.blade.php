@extends('default')

@section('title', 'Montesquieu')

<?php $now = date('Y'); ?>

@section('content')
    <h1>Montesquieu-des-Albères</h1>
    <div class="row-fluid">
        <div class="span5">
            <h2>Réservations</h2>
            <ul class="nav nav-list">
            @for($y = $now; $y <= ($now + 2); $y++)
                <li>
                   <h5>
                        <a href="{{ route('calendar.main', ['year' => $y]) }}">
                           <i class="icon-chevron-right"></i> {{ $y }}
                        </a>
                    </h5>
                </li>
            @endfor
            </ul>
        </div>
        <div class="span5">
            <h2>Réservations Antérieurs</h2>
            <ul class="nav nav-list">
            @for($y = 2012; $y < $now; $y++)
                <li>
                   <h5>
                        <a href="{{ route('calendar.main', ['year' => $y]) }}">
                           <i class="icon-chevron-right"></i> {{ $y }}
                        </a>
                    </h5>
                </li>
            @endfor
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <p>
            Vous pouvez aussi faire une <a href="{{ route('reservation.create') }}">réservation</a>.
            @if(Auth::check())
            Liste des <a href="{{ route('reservation.index') }}">réservations</a>.
            @endif
        </p>
    </div>

@endsection
