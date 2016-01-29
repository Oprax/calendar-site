@extends('default')

@section('title', $title)

@section('css')
        <link href="{{ route('welcome') }}/static/css/datepicker/default.css" rel="stylesheet" />
        <link href="{{ route('welcome') }}/static/css/datepicker/default.date.css" rel="stylesheet" />
@endsection

@section('content')
    <ul class="breadcrumb">
        <li><a href="{{ route('welcome') }}">Accueil</a> <span class="divider">/</span></li><li class="active">Réservations</li>
    </ul>

    <h3>Filtres <button class="btn" id="hide-filter"><i class="icon-plus"></i></button></h3>

    <form id="filter" action="{{ route('reservations.index') }}" method="GET">
        <div id="form-content">
        </div>

        <p><button type="button" data-toggle="modal" data-target="#modal-add-filter" class="btn">Ajouter nouveau filtre</button></p>
        <p><button type="submit" class="btn btn-primary">OK</button></p>
    </form>

    <div id="modal-add-filter" class="modal hide fade">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Filtre</h3>
        </div>
        <div class="modal-body">
            <form id="filter-type">
                <label>Choisir le type de filtre :</label>
                <select name="type">
                    <option value="name">Nom</option>
                    <option value="forename">Prénom</option>
                    <option value="nb_people">Nombre de personne</option>
                    <option value="arrive_at">Date d'arrivée</option>
                    <option value="leave_at">Date de départ</option>
                </select>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="btn">Fermer</button>
            <button type="button" id="add-filter" class="btn btn-primary">OK</button>
        </div>
    </div>

    <a class="btn" href="{{ route('reservations.create') }}">Nouvelle Réservation</a>

    @foreach($reservations as $reservation)
    <div>
        <h1>{{ $reservation->name }} {{ $reservation->forename }}</h1>
        <p>Du {{ $reservation->arrive_at }} au {{ $reservation->leave_at }} pour {{ $reservation->nb_people }} personne(s)</p>
        <p>
        @if(Auth::check())
            <a class="btn btn-primary" href="{{ route('reservations.edit', $reservation->id) }}">Modifier</a>
            {!! Form::open(['url' => route('reservations.destroy', $reservation), 'method' => 'DELETE']) !!}
              <button type="submit" class="btn btn-danger">Supprimer</button>
            {!! Form::close() !!}
        @else
            <a class="btn btn-primary" href="{{ route('reservations.show', $reservation->id) }}">Voir</a>
        @endif
        </p>
    </div>
    @endforeach

@endsection

@section('javascript')
        <script src="{{ route('welcome') }}/static/js/datepicker/picker.js"></script>
        <script src="{{ route('welcome') }}/static/js/datepicker/picker.date.js"></script>
        <script src="{{ route('welcome') }}/static/js/datepicker/fr_FR.js"></script>
        <script type="text/javascript">
        var label = {
            "name": "Nom",
            "forename": "Prénom",
            "nb_people": "Nombre de personne",
            "arrive_at": "Date d'arrivée",
            "leave_at": "Date de départ"
        };

        jQuery(function ($) {
            var datepickerOption = {
                formatSubmit: 'yyyy-mm-dd',
                format: 'yyyy-mm-dd',
                containerHidden: 'body'
            };

            var $form = $('#filter');

            $form.hide();

            $('#hide-filter').click(function() {
                $icon = $('i', this);

                if ($icon.hasClass('icon-minus')) {
                    $icon.removeClass('icon-minus');
                    $icon.addClass('icon-plus');
                } else {
                    $icon.removeClass('icon-plus');
                    $icon.addClass('icon-minus');
                }

                $form.toggle("slow");
            });

            $('#add-filter').click(function() {
                $('#modal-add-filter').modal('hide');

                var type = $('#filter-type').serializeArray();
                type = type[0].value;

                if ($('#' + type).length){
                    alert('Ce filtre existe déjà !');
                } else {
                    var html = '<div id="form-' + type + '">' +
                    '   <label>' + label[type] + ' :</label>' +
                    '   <select id="select-' + type + '">' +
                    '       <option value="eq" selected>égale à</option>' +
                    '       <option value="lte">plus petit ou égale à</option>' +
                    '       <option value="gte">plus grand ou égale à</option>' +
                    '       <option value="lt">plus petit que</option>' +
                    '       <option value="gt">plus grand que</option>' +
                    '   </select>' +
                    '   <input type="text" id="' + type + '" name="' + type + '">' +
                    '   <button type="button" data-del="#form-' + type + '" class="btn btn-danger">Supprimer ce filtre</button>' +
                    '</div>';


                    if (type == 'name' || type == 'forename') {
                        html = '<div id="form-' + type + '">' +
                        '   <label>' + label[type] + ' :</label>' +
                        '   <input type="text" id="' + type + '" name="' + type + '__eq">' +
                        '   <button type="button" data-del="#form-' + type + '" class="btn btn-danger">Supprimer ce filtre</button>' +
                        '</div>';
                    }

                    $('#form-content').append(html);

                    var op = $('#select-' + type + ' option:selected').val();

                    if (op !== undefined) {
                        $('#' + type).attr('name', type + '__' + op);

                        $('#select-' + type).change(function () {
                            op = $('#select-' + type + ' option:selected').val();
                            $('#' + type).attr('name', type + '__' + op);
                        });
                    }


                    $('button[data-del]').click(function() {
                        var selector = $(this).attr('data-del');
                        $(selector).remove();
                    });

                    $('#arrive_at').pickadate(datepickerOption);
                    $('#leave_at').pickadate(datepickerOption);
                }
            });

            $('button[data-del]').click(function() {
                var selector = $(this).attr('data-del');
                $(selector).remove();
            });

        });

        </script>
@endsection