@extends('default')

@section('title', 'Montesquieu')

<?php
$now = date('Y');
?>

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
            @for($y = 2013; $y < $now; $y++)
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
            Vous pouvez aussi effectuer une <a href="{{ route('reservation.create') }}">réservation</a>.
        </p>
        @if(Auth::check())
        <p>
            Vous pouvez accédez à la liste des <a href="{{ route('reservation.index') }}">réservations</a>. Vous pouvez également voir l'évolution des réservations sous forme de <a href="{{ route('stats.index') }}">statistique</a>.
        </p>
        @endif
    </div>
    <div class="row-fluid">
        <h3>L'église Saint-Saturnin de Montesquieu-des-Albères</h3>
        <p>
            <a title="By AC (Own work) [GFDL (http://www.gnu.org/copyleft/fdl.html) or CC BY-SA 3.0 (http://creativecommons.org/licenses/by-sa/3.0)], via Wikimedia Commons" href="https://commons.wikimedia.org/wiki/File%3AEglise_de_Montesquieu-des-Alb%C3%A8res_01.JPG">
                <img  class="img-polaroid" width="512" alt="Eglise de Montesquieu-des-Albères" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/90/Eglise_de_Montesquieu-des-Alb%C3%A8res_01.JPG/512px-Eglise_de_Montesquieu-des-Alb%C3%A8res_01.JPG"/>
            </a>
        </p>
        <div class="span5 text-center">
            <p>
                L'église a été consacrée le 10 juin 1123 par l'évêque d'Elne. Bien que l'édifice ait subi quelques remaniements et ajouts au fil des siècles, il est à peu près identique à son aspect d'origine.
            </p>
            <p>
                <small>Source : <a href="https://fr.wikipedia.org/wiki/%C3%89glise_Saint-Saturnin_de_Montesquieu-des-Alb%C3%A8res">Wikipédia</a></small>
            </p>
        </div>
    </div>

@endsection
