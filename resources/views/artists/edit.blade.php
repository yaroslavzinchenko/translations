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

        <form method="POST" action="/artists/edit" id="editArtistForm" autocomplete="off">
            @csrf
            <div class="form-group">
                <label for="artist">Исполнитель</label>
                <select name="artist" id="artist" form="editArtistForm" class="form-control" required onchange="changeFormArtistEdited()">
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
            <div class="form-group" id="formArtistEditedEn">
                <label for="artistEditedEn">Новое имя исполнителя (на английском)</label>
                <input type="text" name="artistEditedEn" id="artistEditedEn" class="form-control" required>
            </div>
            <div class="form-group" id="formArtistEditedRu">
                <label for="artistEditedRu">Новое имя исполнителя (на русском)</label>
                <input type="text" name="artistEditedRu" id="artistEditedRu" class="form-control" required>
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
    <script src="/js/onBeforeUnload.js"></script>
@endsection

<script>
    $(function() {
        $('#formArtistEditedEn').hide();
        $('#artist').change(function(){
            if($('#artist').val() != '') {
                $('#formArtistEditedEn').show();
            } else {
                $('#formArtistEditedEn').hide();
            }
        });
    });

    $(function() {
        $('#formArtistEditedRu').hide();
        $('#artist').change(function(){
            if($('#artist').val() != '') {
                $('#formArtistEditedRu').show();
            } else {
                $('#formArtistEditedRu').hide();
            }
        });
    });

    function changeFormArtistEdited() {
        let select = document.getElementById("artist");
        document.getElementById('artistEditedEn').value = select.options[select.selectedIndex].text;
        document.getElementById('artistEditedRu').value = select.options[select.selectedIndex].text;
    }
</script>
