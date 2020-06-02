<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    public function getArtists()
    {
        $artists = DB::select('
                            SELECT id,
                            artist_en,
                            artist_ru
                            FROM ARTISTS ORDER BY ARTIST_RU
                            ');

        return $artists;
    }

    private function getArtistTracks($artistId, $artist)
    {
        $artist = str_replace('_', ' ', $artist);
        $artist = ucwords($artist);
        $artistTracks = DB::select("
                                SELECT * FROM TRACKS
                                WHERE
                                ARTIST_1 = " . $artistId . "
                                OR
                                ARTIST_2 = " . $artistId . "
                                OR
                                ARTIST_3 = " . $artistId . "
                                ORDER BY TRACK_NAME_RU
                                ");
        return $artistTracks;
    }

    private function getArtistById($artistId)
    {
        $artist = DB::select("SELECT * FROM ARTISTS WHERE ID = " . $artistId);
        return $artist[0];
    }

    public function index()
    {
        $title = "Исполнители";

        $artists = $this->getArtists();
        $trArray = [];
        foreach($artists as $artist)
        {
            $artistId = $artist->id;
            if (!empty($artist->artist_ru))
            {
                $artist = $artist->artist_ru;

            }
            else continue;

            $artistToLower = strtolower($artist);
            $tr = "<tr><td><a href='artists/" . $artistId . "/" . str_replace(' ', '_', str_replace("'", "", $artistToLower)) . "'>";
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

    public function showArtistSongs($artistId, $artist)
    {
        $title = $artist;
        $title = str_replace('_', ' ', $title);
        $title = ucwords($title);
        $artistTracks = $this->getArtistTracks($artistId, $artist);

        $trArray = [];
        foreach($artistTracks as $artistTrack)
        {
            $trackId = $artistTrack->id;
            $track_name_en = $artistTrack->track_name_en;
            $track_name_en = strtolower($track_name_en);

            $tr = "<tr><td><a href='/tracks/" . $trackId . "/" . str_replace(' ', '_', str_replace("'", "", $track_name_en)) . "'>";
            $tr .= "<span class='song-name'>";
            if ($artistTrack->track_name_ru)
            {
                $tr .= $artistTrack->track_name_ru;
            }
            else
            {
                $tr .= $artistTrack->track_name_en;
            }
            $tr .= "</span> - <span class='song-artist'>";

            if ($artistTrack->artist_1 != NULL)
            {
                $artist1 = $this->getArtistById($artistTrack->artist_1);
            }
            if ($artistTrack->artist_2 != NULL)
            {
                $artist2 = $this->getArtistById($artistTrack->artist_2);
            }
            else $artist2 = NULL;
            if ($artistTrack->artist_3 != NULL)
            {
                $artist3 = $this->getArtistById($artistTrack->artist_3);
            }
            else $artist3 = NULL;

            if (!empty($artist1->artist_ru))
            {
                $tr .= $artist1->artist_ru;
            }
            else
            {
                $tr .= $artist1->artist_en;
            }
            if (!empty($artist2->artist_ru))
            {
                $tr .= ', ' . $artist2->artist_ru;
            }
            else if (!empty($artist2->artist_en))
            {
                $tr .= ', ' . $artist2->artist_en;
            }
            if (!empty($artist3->artist_ru))
            {
                $tr .= ', ' . $artist3->artist_ru;
            }
            else if (!empty($artist3->artist_en))
            {
                $tr .= ', ' . $artist3->artist_en;
            }
            $tr .= "</span></a></td></tr>";
            $trArray [] = $tr;
        }

        return view('artists.showArtistSongs', [
            'title' => $title,
            'trArray' => $trArray
        ]);
    }

    public function add(Request $request)
    {
        $title = "Добавить исполнителя";

        if ($request->isMethod('get'))
        {
            $msg = '';
            $msgClass = '';

            return view('artists.add', [
                'title' => $title,
                'msg' => $msg,
                'msgClass' => $msgClass
            ]);
        }
        else if ($request->isMethod('post'))
        {
            $this->validate($request, [
                'artist_en' => 'required',
            ]);

            // Проверяем, не пусто ли необходимое поле.
            if (!empty($request['artist_en']))
            {
                $artist_en = $request['artist_en'];
                if (!empty($request['artist_ru']))
                {
                    $artist_ru = $request['artist_ru'];
                }
                else
                {
                    $artist_ru = $request['artist_en'];
                }

                // Смотрим, есть ли автор, которого пытаемся добавить, в таблице artists.
                $noMatches = true;
                $artists = (new ArtistController())->getArtists();
                foreach($artists as $artist)
                {
                    if (strtoupper($artist_ru) == strtoupper($artist->artist_ru) or strtoupper($artist_ru) == strtoupper($artist->artist_en))
                    {
                        $noMatches = false;
                    }
                    else if (strtoupper($artist_en) == strtoupper($artist->artist_ru) or strtoupper($artist_en) == strtoupper($artist->artist_en))
                    {
                        $noMatches = false;
                    }
                    else
                    {
                        continue;
                    }
                }

                if ($noMatches)
                {
                    DB::table('artists')->insert(
                        ['artist_en' => $artist_en, 'artist_ru' => $artist_ru]
                    );

                    $msg = 'Исполнитель добавлен';
                    $msgClass = 'alert-success';

                    return view('artists.add', [
                        'title' => $title,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }
                else
                {
                    $msg = 'Такой исполнитель уже есть в базе';
                    $msgClass = 'alert-danger';

                    return view('artists.add', [
                        'title' => $title,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }
            }
        }
    }
}
