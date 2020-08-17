@extends('layouts.main')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


@section('content')
    <div class="container">
        <br>

        @if ($msg != '')
            <div class="alert {{$msgClass}}">{{$msg}}</div>
        @endif

        <form method="POST" action="/artists/add" autocomplete="off">
            @csrf
            <div class="form-group">
                <label for="artist_en">Исполнитель (по-английски)</label>
                <input type="text" name="artist_en" id="artist_en" class="form-control" required onkeyup='saveValue(this);'>
            </div>
            <div class="form-group">
                <label for="artist_ru">Исполнитель (по-русски)</label>
                <input placeholder="Не обязательное поле" type="text" name="artist_ru" id="artist_ru" class="form-control" onkeyup='saveValue(this);'>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Добавить</button>
        </form>
        <br>
    </div>

    <style>
        a:hover {
            color: black;
            text-decoration: none;
        }
    </style>
@endsection

@section('bottomScripts')
    <script src="/js/keepFormArtistAddInputValue.js"></script>
    <script src="/js/onBeforeUnload.js"></script>
@endsection
