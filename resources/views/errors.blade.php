@if (count($errors) > 0)
    <div class="ui negative message">
        <i class="close icon"></i>
        <ul class="list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif