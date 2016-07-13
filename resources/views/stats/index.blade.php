@extends('default')

@section('title', $title)

<?php $now = date('Y'); ?>

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a></li>
        <li class="active">{{ $title }}</li>
    </ul>
    
    <h1>Montesquieu-des-Albères</h1>
    <h2>Satistiques</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>Réservations</h3>
            <ul class="nav nav-list">
            @for($y = $now; $y <= ($now + 2); $y++)
                <li>
                   <h5>
                        <a href="{{ route('stats.chart', ['year' => $y]) }}">
                           <span class="glyphicon glyphicon-menu-right"></span> {{ $y }}
                        </a>
                    </h5>
                </li>
            @endfor
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Réservations Antérieurs</h3>
            <ul class="nav nav-list">
            @for($y = 2013; $y < $now; $y++)
                <li>
                   <h5>
                        <a href="{{ route('stats.chart', ['year' => $y]) }}">
                           <span class="glyphicon glyphicon-menu-right"></span> {{ $y }}
                        </a>
                    </h5>
                </li>
            @endfor
            </ul>
        </div>
    </div>
@endsection
