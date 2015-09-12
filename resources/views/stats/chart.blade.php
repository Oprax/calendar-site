@extends('stats')

@section('title', 'Statistiques &bull; ' . $year)

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li>
        <li><a href="{{ route('stats.index') }}">Statistiques</a> <span class="divider">/</span></li>
        <li class="active">{{ $year }}</li>
    </ul>

    <div class="text-center">
        <h1>Année {{ $year }}</h1>
        <div id="charts"></div>
    </div>
    
    <ul class="pager">
        <li><a href="{{ route('stats.chart', ['year' => ($year - 1)]) }}">&larr; Précédent</a></li>
        <li><a href="{{ route('stats.chart', ['year' => ($year + 1)]) }}">Suivant &rarr;</a></li>
    </ul>

    <script type="text/javascript">
    var daily = {!! json_encode($daily) !!};
    var monthly = {!! json_encode($monthly) !!};
    var months = {!! json_encode($months) !!};
    var year = {{ $year }};
    </script>
@endsection
