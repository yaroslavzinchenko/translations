@extends('layouts.main')

@section('content')
    <section class="translations-section">

        <header class="translations-header">
            @if (!empty($artist2->artist_ru))
            @if (!empty($artist3->artist_ru))
            <h1 class='translations-header-h1'>{{$artist1->artist_ru}}, {{$artist2->artist_ru}}, {{$artist3->artist_ru}} - {{$track->track_name_ru}}</h1>
            @else
            <h1 class='translations-header-h1'>{{$artist1->artist_ru}}, {{$artist2->artist_ru}} - {{$track->track_name_ru}}</h1>
            @endif
            @else
            <h1 class='translations-header-h1'>{{$artist1->artist_ru}} - {{$track->track_name_ru}}</h1>
            @endif
        </header>

        <div id="textWithoutTranslation" style="display: block;">
            <div class="card-lyrics card-shadow">

                @foreach($lyrics as $line)
                    @php
                        $line = rtrim($line);
                    @endphp
                    @if($line == ctype_space($line))
                            <br>
                        @continue
                    @endif
                    <div class="string-container">{{$line}}</div>
                @endforeach

            </div>
        </div>

        @if(!empty($track->spotify_link) or !empty($track->youtube_link))
        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Ссылки</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($track->spotify_link))
            <tr>
                <td><a href="{{$track->spotify_link}}">Spotify</a></td>
            </tr>
            @endif
            @if(!empty($track->youtube_link))
            <tr>
                <td><a href="{{$track->youtube_link}}" target='_blank'>YouTube</a></td>
            </tr>
            @endif
            </tbody>
        </table>
        @endif

    </section>
@endsection
