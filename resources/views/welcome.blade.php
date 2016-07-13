@extends('default')

@section('title', 'Montesquieu')

<?php
$now = date('Y');
?>

@section('content')
    <h1>Montesquieu-des-Albères</h1>
    <div class="row">
        <div class="col-md-6">
            <h2>Réservations</h2>
            <ul class="nav nav-list">
            @for($y = $now; $y <= ($now + 2); $y++)
                <li>
                   <h5>
                        <a href="{{ route('calendar.main', ['year' => $y]) }}">
                           <span class="glyphicon glyphicon-menu-right"></span> {{ $y }}
                        </a>
                    </h5>
                </li>
            @endfor
            </ul>
        </div>
        <div class="col-md-6">
            <h2>Réservations Antérieures</h2>
            <ul class="nav nav-list">
            @for($y = 2013; $y < $now; $y++)
                <li>
                   <h5>
                        <a href="{{ route('calendar.main', ['year' => $y]) }}">
                           <span class="glyphicon glyphicon-menu-right"></span> {{ $y }}
                        </a>
                    </h5>
                </li>
            @endfor
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <a class="btn btn-default" href="{{ route('reservations.create') }}">Nouvelle Réservation</a>
        </div>
        <div class="col-md-2">
            <a class="btn btn-default" href="{{ route('reservations.index') }}">Liste des Réservations</a>
        </div>
        @if(Auth::check())
        <div class="col-md-2">
            <a class="btn btn-default" href="{{ route('stats.index') }}">Statistiques</a>
        </div>
        @endif
    </div>
    <div class="row">
        <h3>L'église Saint-Saturnin de Montesquieu-des-Albères</h3>
        <p class="media">
            <a title="By AC (Own work) [GFDL (http://www.gnu.org/copyleft/fdl.html) or CC BY-SA 3.0 (http://creativecommons.org/licenses/by-sa/3.0)], via Wikimedia Commons" href="https://commons.wikimedia.org/wiki/File%3AEglise_de_Montesquieu-des-Alb%C3%A8res_01.JPG">
                <img class="img-thumbnail" width="512" alt="Eglise de Montesquieu-des-Albères" src="{{ route('welcome') }}/static/img/800px-eglise-montesquieu.jpg"/>
            </a>
        </p>
        <div class="col-md-5 text-center">
            <p>
                L'église a été consacrée le 10 juin 1123 par l'évêque d'Elne. Bien que l'édifice ait subi quelques remaniements et ajouts au fil des siècles, il est à peu près identique à son aspect d'origine.
            </p>
            <p>
                <small>Source : <a href="https://fr.wikipedia.org/wiki/%C3%89glise_Saint-Saturnin_de_Montesquieu-des-Alb%C3%A8res">Wikipédia</a></small>
            </p>
        </div>
    </div>

@endsection
