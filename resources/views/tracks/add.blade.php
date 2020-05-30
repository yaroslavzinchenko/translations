<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@extends('layouts.main')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

@section('content')
    <div class="container">
        <br>

        @if ($msg != '')
            <div class="alert {{$msgClass}}">{{$msg}}</div>
        @endif

        <form method="POST" action="/tracks/add" id="addTrackForm" autocomplete="off">
            @csrf
            <div class="form-group">
                <label for="track_name_en">Название (по-английски)</label>
                <input type="text" name="track_name_en" id="track_name_en" class="form-control" required onkeyup='saveValue(this);'>
            </div>
            <div class="form-group">
                <label for="track_name_ru">Название (по-русски)</label>
                <input type="text" name="track_name_ru" id="track_name_ru" class="form-control" placeholder="Не обязательное поле" onkeyup='saveValue(this);'>
            </div>
            <div class="form-group">
                <label for="artist_1">Исполнитель 1</label>
                <select name="artist_1" id="artist_1" form="addTrackForm" class="form-control" required>
                    <option label="" value=""></option>
                    @foreach($artists as $artist)
                        @if($artist->artist_ru != $artist->artist_en)
                            <option value="{{$artist->id}}">{{$artist->artist_en}} - {{$artist->artist_ru}}</option>
                        @else
                            <option value="{{$artist->id}}">{{$artist->artist_en}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="form_artist_2">
                <label for="artist_2">Исполнитель 2</label>
                <select name="artist_2" id="artist_2" form="addTrackForm" class="form-control">
                    <option label="" value="" selected></option>
                    @foreach($artists as $artist)
                        @if($artist->artist_ru != $artist->artist_en)
                            <option value="{{$artist->id}}">{{$artist->artist_en}} - {{$artist->artist_ru}}</option>
                        @else
                            <option value="{{$artist->id}}">{{$artist->artist_en}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="form_artist_3">
                <label for="artist_3">Исполнитель 3</label>
                <select name="artist_3" id="artist_3" form="addTrackForm" class="form-control">
                    <option label="" value="" selected></option>
                    @foreach($artists as $artist)
                        @if($artist->artist_ru != $artist->artist_en)
                            <option value="{{$artist->id}}">{{$artist->artist_en}} - {{$artist->artist_ru}}</option>
                        @else
                            <option value="{{$artist->id}}">{{$artist->artist_en}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            Картинка вместо текста
            <div class="form-check">
                <input class="form-check-input" type="radio" name="image_for_lyrics" id="image_for_lyrics_no" value="image_for_lyrics_no" checked>
                <label class="form-check-label" for="image_for_lyrics_no">
                    Нет
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="image_for_lyrics" id="image_for_lyrics_yes" value="image_for_lyrics_yes">
                <label class="form-check-label" for="image_for_lyrics_yes">
                    Да
                </label>
            </div>
            <br>
            <div class="form-group lyrics_div" id="lyrics_div">
                <label for="lyrics">Текст</label>
                <textarea name="lyrics" id="lyrics" class="form-control" rows="20" required onkeyup='saveValue(this);'></textarea>
            </div>
            <div class="form-group">
                <label for="spotify_link">Ссылка Spotify</label>
                <input placeholder="Не обязательное поле" type="text" name="spotify_link" id="spotify_link" class="form-control" onkeyup='saveValue(this);'>
            </div>
            <div class="form-group">
                <label for="youtube_link">Ссылка YouTube</label>
                <input placeholder="Не обязательное поле" type="text" name="youtube_link" id="youtube_link" class="form-control" onkeyup='saveValue(this);'>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Отправить</button>
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
    <script src="/js/keepFormTrackAddInputValue.js"></script>
    <script src="/js/onBeforeUnload.js"></script>
@endsection

<script>
    $(function() {
        $('#form_artist_2').hide();
        $('#artist_1').change(function(){
            if($('#artist_1').val() != '') {
                $('#form_artist_2').show();
            } else {
                $('#form_artist_2').hide();
            }
        });
    });
    $(function() {
        $('#form_artist_3').hide();
        $('#artist_2').change(function(){
            if($('#artist_2').val() != '') {
                $('#form_artist_3').show();
            } else {
                $('#form_artist_3').hide();
            }
        });
    });
</script>
