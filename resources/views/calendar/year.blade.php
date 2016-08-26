@extends('default')

@section('title', $year)

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <div class="section active">{{ $year }}</div>
    </div>

    <h1 class="ui center aligned header">Montesquieu-des-Albères</h1>
    <h2 class="ui center aligned header">{{ $year }}</h2>
    <div class="ui grid center aligned">
    @foreach($months as $key => $month)
        <div class="four wide column aligned centered">
            <a class="ui button" href="{{ route('calendar.main', ['year' => $year, 'month' => ($key + 1)]) }}">
                {{ $month }}
            </a>
        </div>
    @endforeach
    </div>

    <div class="ui two item menu centered">
        <a class="item" href="{{ route('calendar.main', ['year' => ($year - 1)]) }}"><i class="chevron left icon"></i> Précédent</a>
        <a class="item" href="{{ route('calendar.main', ['year' => ($year + 1)]) }}">Suivant <i class="chevron right icon"></i></a>
    </div>
@endsection