<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@extends('layouts.main')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

@section('content')
    <div class="container">
        <br>

        @if ($msg != '')
            <div class="alert {{$msgClass}}">{{$msg}}</div>
        @endif

        <form method="POST" action="/tracks/edit/{{$track->id}}" id="addTrackForm" autocomplete="off">
            @method('PATCH')
            @csrf
            <div class="form-group">
                <label for="track_name_en">Название (по-английски)</label>
                <input type="text" name="track_name_en" id="track_name_en" class="form-control" value="{{$track->track_name_en}}" required onkeyup='saveValue(this);'>
            </div>
            <div class="form-group">
                <label for="track_name_ru">Название (по-русски)</label>
                <input type="text" name="track_name_ru" id="track_name_ru" class="form-control" value="{{$track->track_name_ru}}" required placeholder="Необязательное поле" onkeyup='saveValue(this);'>
            </div>
            <div class="form-group">
                <label for="artist_1">Исполнитель 1</label>
                <select name="artist_1" id="artist_1" form="addTrackForm" class="form-control" required>
                    <option value="{{$artist1->id}}" selected>{{$artist1->artist_ru}}</option>
                    @foreach($artists as $artist)
                        @if($artist->id == $artist1->id)
                            @continue;
                        @endif

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
                    <option value=""></option>
                    <option value="{{$artist2 != NULL ? $artist2->id : ''}}" selected>{{$artist2 != NULL ? $artist2->artist_ru : ''}}</option>
                    @foreach($artists as $artist)
                        @if($artist2 != NULL)
                            @if($artist->id == $artist2->id)
                                @continue;
                            @endif
                        @endif

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
                    <option value=""></option>
                    <option value="{{$artist3 != NULL ? $artist3->id : ''}}" selected>{{$artist3 != NULL ? $artist3->artist_ru : ''}}</option>
                    @foreach($artists as $artist)
                        @if($artist3 != NULL)
                            @if($artist->id == $artist3->id)
                                @continue;
                            @endif
                        @endif

                        @if($artist->artist_ru != $artist->artist_en)
                            <option value="{{$artist->id}}">{{$artist->artist_en}} - {{$artist->artist_ru}}</option>
                        @else
                            <option value="{{$artist->id}}">{{$artist->artist_en}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <br>
            <div class="form-group lyrics_div" id="lyrics_div">
                <label for="lyrics">Текст</label>
                <textarea name="lyrics" id="lyrics" class="form-control" rows="20" required onkeyup='saveValue(this);'>{{$track->lyrics}}</textarea>
            </div>
            <div class="form-group">
                <label for="spotify_link">Ссылка Spotify</label>
                <input placeholder="Необязательное поле" type="text" name="spotify_link" id="spotify_link" class="form-control" value="{{$track->spotify_link}}" onkeyup='saveValue(this);'>
            </div>
            <div class="form-group">
                <label for="youtube_link">Ссылка YouTube</label>
                <input placeholder="Необязательное поле" type="text" name="youtube_link" id="youtube_link" class="form-control" value="{{$track->youtube_link}}" onkeyup='saveValue(this);'>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Изменить</button>
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
    <script src="/js/onBeforeUnload.js"></script>
@endsection


