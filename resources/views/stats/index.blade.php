@extends('default')

@section('title', $title)

<?php $now = date('Y'); ?>

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ $title }}</div>
    </div>
    
    <h1 class="ui center aligned header">Montesquieu-des-Albères</h1>
    <h2 class="ui center aligned header">Statistiques</h2>
    <div class="ui grid two column centered">
        <div class="five wide column">
            <h3>Réservations</h3>
            <div class="ui list">
                @for($y = $now; $y <= ($now + 2); $y++)
                    <div class="item">
                        <i class="angle right icon"></i>
                        <div class="content">
                            <a href="{{ route('stats.chart', ['year' => $y]) }}">{{ $y }}</a>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="five wide column">
            <h3>Réservations Antérieures</h3>
            <div class="ui list">
                @for($y = 2013; $y < $now; $y++)
                    <div class="item">
                        <i class="angle right icon"></i>
                        <div class="content">
                            <a href="{{ route('stats.chart', ['year' => $y]) }}">{{ $y }}</a>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection
