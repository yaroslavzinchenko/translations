<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    private function getArtists()
    {
        $artists = DB::select('
                            select distinct artist from
                            (
                                (SELECT distinct artist_1_ru as artist from tracks)
                                union
                                (SELECT distinct artist_2_ru as artist from tracks)
                            ) t where artist is not null order by artist');

        return $artists;
    }

    private function getArtistTracks($artist)
    {
        $artist = str_replace('_', ' ', $artist);
        $artist = ucwords($artist);
        $artistTracks = DB::select("
                                SELECT * FROM tracks
                                WHERE artist_1_ru = '". $artist . "'
                                or artist_2_ru = '" . $artist . "'
                                or artist_3_ru = '" . $artist . "'
                                order by track_name
                                ");

        return $artistTracks;
    }

    public function index()
    {
        $title = "Исполнители";

        $artists = $this->getArtists();
        $trArray = [];
        foreach($artists as $artist)
        {
            if (!empty($artist->artist))
            {
                $artist = $artist->artist;
            }
            else continue;

            $artistToLower = strtolower($artist);
            $tr = "<tr><td><a href='artists/" . str_replace(' ', '_', str_replace("'", "", $artistToLower)) . "'>";
            $tr .= "<span class='song-name'>";
            $tr .= $artist;
            $tr .= "</span></a></td></tr>";

            $trArray [] = $tr;
        }

        return view('artists.index', [
            'title' => $title,
            'trArray' => $trArray
        ]);
    }

    public function showArtistSongs($artist)
    {
        $title = $artist;
        $title = str_replace('_', ' ', $title);
        $title = ucwords($title);
        $artistTracks = $this->getArtistTracks($artist);

        $trArray = [];
        foreach($artistTracks as $artistTrack)
        {
            $id = $artistTrack->id;
            $track_name = $artistTrack->track_name;
            $track_name = strtolower($track_name);

            $tr = "<tr><td><a href='/tracks/" . $id . "/" . str_replace(' ', '_', str_replace("'", "", $track_name)) . "'>";
            $tr .= "<span class='song-name'>";
            if ($artistTrack->track_name_ru)
            {
                $tr .= $artistTrack->track_name_ru;
            }
            else
            {
                $tr .= $artistTrack->track_name;
            }
            $tr .= "</span> - <span class='song-artist'>";
            if ($artistTrack->artist_1_ru)
            {
                $tr .= $artistTrack->artist_1_ru;
            }
            else
            {
                $tr .= $artistTrack->artist_1;
            }
            if ($artistTrack->artist_2_ru and $artistTrack->artist_2_ru !== null)
            {
                $tr .= ', ' . $artistTrack->artist_2_ru;
            }
            else if ($artistTrack->artist_2 and $artistTrack->artist_2 !== null)
            {
                $tr .= ', ' . $artistTrack->artist_2;
            }
            if ($artistTrack->artist_3_ru and $artistTrack->artist_3_ru !== null)
            {
                $tr .= ', ' . $artistTrack->artist_3_ru;
            }
            else if ($artistTrack->artist_3 and $artistTrack->artist_3 !== null)
            {
                $tr .= ', ' . $artistTrack->artist_3;
            }
            $tr .= "</span></a></td></tr>";
            $trArray [] = $tr;
        }

        return view('artists.showArtistSongs', [
            'title' => $title,
            'trArray' => $trArray
        ]);
    }
}
