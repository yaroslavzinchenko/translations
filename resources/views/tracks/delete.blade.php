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

        <form method="POST" action="/tracks/delete" id="deleteTrackForm" autocomplete="off">
            @method('DELETE')
            @csrf
            <div class="form-group">
                <label for="track_id">Трек</label>
                <select name="track_id" id="track_id" form="deleteTrackForm" class="form-control" required>
                    <option></option>
                    @foreach($tracks as $track)
                        <option value="{{$track->id}}"><b>{{$track->track_name_ru}}</b> - {{$track->artist_ru}}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-danger">Удалить</button>
        </form>
    </div>
@endsection
