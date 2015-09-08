@extends('default')

@section('title', $year)

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li>
        <li class="active">{{ $year }}</li>
    </ul>

    <div class="row">
        <p class="text-center">
            <h1>Montesquieu-des-Albères</h1>
        </p>
        <div class="span6">
            <h2>{{ $year }}</h2>
            <ul class="nav nav-list">
            @foreach($months as $key => $month)
                <li>
                    <h5>
                        <a href="{{ route('calendar.main', ['year' => $year, 'month' => ($key + 1)]) }}">
                            <i class="icon-chevron-right"></i> {{ $month }}
                        </a>
                    </h5>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
    
    <ul class="pager">
        <li><a href="{{ route('calendar.main', ['year' => ($year - 1)]) }}">&larr; Précédent</a></li>
        <li><a href="{{ route('calendar.main', ['year' => ($year + 1)]) }}">Suivant &rarr;</a></li>
    </ul>
@endsection