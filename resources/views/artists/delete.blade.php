@extends('layouts.main')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

@section('content')
    <div class="container">
        <br>

        @if ($msg != '')
            <div class="alert {{$msgClass}}">{{$msg}}</div>
        @endif

        <form method="POST" action="/artists/delete" id="deleteArtistForm" autocomplete="off">
            @method('DELETE')
            @csrf
            <div class="form-group">
                <label for="artist_id">Исполнитель</label>
                <select name="artist_id" id="artist_id" form="deleteArtistForm" class="form-control" required>
                    @foreach($artists as $artist)
                        @if($artist->artist_ru != $artist->artist_en)
                            <option value="{{$artist->id}}">{{$artist->artist_en}} - {{$artist->artist_ru}}</option>
                        @else
                            <option value="{{$artist->id}}">{{$artist->artist_en}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-danger">Удалить</button>
        </form>
    </div>
@endsection
