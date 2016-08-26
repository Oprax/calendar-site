@extends('default')

@section('title', 'Montesquieu')

<?php
$now = date('Y');
?>

@section('content')
    <h1>Montesquieu-des-Albères</h1>
    <div class="ui grid two column centered">
        <div class="five wide column">
            <h2>Réservations</h2>
            <div class="ui list">
            @for($y = $now; $y <= ($now + 2); $y++)
                <div class="item">
                    <i class="angle right icon"></i>
                    <div class="content">
                        <a href="{{ route('calendar.main', ['year' => $y]) }}">{{ $y }}</a>
                    </div>
                </div>
            @endfor
            </div>
        </div>
        <div class="five wide column">
            <h2>Réservations Antérieures</h2>
            <div class="ui list">
            @for($y = 2013; $y < $now; $y++)
                <div class="item">
                    <i class="angle right icon"></i>
                    <div class="content">
                        <a href="{{ route('calendar.main', ['year' => $y]) }}">{{ $y }}</a>
                    </div>
                </div>
            @endfor
            </div>
        </div>
    </div>
    <div class="ui grid centered">
        <div class="three wide column">
            <a class="ui button" href="{{ route('reservations.create') }}">Nouvelle Réservation</a>
        </div>
        <div class="three wide column">
            <a class="ui button" href="{{ route('reservations.index') }}">Liste des Réservations</a>
        </div>
        @if(Auth::check())
        <div class="three wide column">
            <a class="ui button" href="{{ route('stats.index') }}">Statistiques</a>
        </div>
        @endif
    </div>
    <div class="ui card centered">
        <div class="content">
            <h3 class="header">L'église Saint-Saturnin de Montesquieu-des-Albères</h3>
        </div>
        <div class="image">
            <a title="By AC (Own work) [GFDL (http://www.gnu.org/copyleft/fdl.html) or CC BY-SA 3.0 (http://creativecommons.org/licenses/by-sa/3.0)], via Wikimedia Commons" href="https://commons.wikimedia.org/wiki/File%3AEglise_de_Montesquieu-des-Alb%C3%A8res_01.JPG">
                <img width="290" alt="Eglise de Montesquieu-des-Albères" src="{{ route('welcome') }}/static/img/800px-eglise-montesquieu.jpg"/>
            </a>
        </div>
        <div class="content">
            <div class="description">
                L'église a été consacrée le 10 juin 1123 par l'évêque d'Elne. Bien que l'édifice ait subi quelques remaniements et ajouts au fil des siècles, il est à peu près identique à son aspect d'origine.
            </div>
        </div>
        <div class="extra content">
            <small>Source : <a href="https://fr.wikipedia.org/wiki/%C3%89glise_Saint-Saturnin_de_Montesquieu-des-Alb%C3%A8res">Wikipédia</a></small>
        </div>
    </div>

@endsection
