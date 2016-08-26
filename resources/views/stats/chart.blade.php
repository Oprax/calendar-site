@extends('default')

@section('title', 'Statistiques &bull; ' . $year)

@section('content')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('welcome') }}">Accueil</a>
        <i class="right angle icon divider"></i>
        <a class="section" href="{{ route('stats.index') }}">Statistiques</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ $year }}</div>
    </div>

    <h1 class="ui center aligned header">Année {{ $year }}</h1>
    <div id="charts"></div>

    <div class="ui two item menu centered">
        <a class="item" href="{{ route('stats.chart', ['year' => ($year - 1)]) }}"><i class="chevron left icon"></i> Précédent</a>
        <a class="item" href="{{ route('stats.chart', ['year' => ($year + 1)]) }}">Suivant <i class="chevron right icon"></i></a>
    </div>

    <script type="text/javascript">
    var daily = {!! json_encode($daily) !!};
    var monthly = {!! json_encode($monthly) !!};
    var months = {!! json_encode($months) !!};
    var year = {{ $year }};
    </script>
@endsection

@section('javascript')
        <script src="{{ route('welcome') }}/static/js/highcharts.min.js"></script>
        <script src="{{ route('welcome') }}/static/js/stats.js"></script>
@endsection