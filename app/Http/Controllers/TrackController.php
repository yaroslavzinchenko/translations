<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ArtistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function getTracks()
    {
        $tracks = DB::select('
                                    SELECT *
                                    FROM TRACKS
                                    ORDER BY TRACK_NAME_RU
                                    ');

        return $tracks;
    }

    public function getTracksWithArtistNames()
    {
        $tracks = DB::select
        ('
            WITH T1 AS (
            SELECT ID AS ARTIST_ID,
            artist_en,
            artist_ru,
            add_time
            FROM ARTISTS
            ),
            T2 AS (SELECT * FROM TRACKS)
            SELECT * FROM T2
            INNER JOIN T1
            ON T2.ARTIST_1 = T1.ARTIST_ID'
        );

        return $tracks;
    }

    private function getTrackById($trackId)
    {
        $track = DB::table('tracks')->where('id', '=', $trackId)->get();
        return $track;
    }

    private function getArtistById($artistId)
    {
        $artist = DB::select("SELECT * FROM ARTISTS WHERE ID = " . $artistId);
        return $artist[0];
    }

    public function index()
    {
        $title = "Главная страница";

        $tracks = $this->getTracks();
        $trArray = [];

        foreach($tracks as $track)
        {
            if ($track->artist_1 != NULL)
            {
                $artist1 = $this->getArtistById($track->artist_1);
            }
            if ($track->artist_2 != NULL)
            {
                $artist2 = $this->getArtistById($track->artist_2);
            }
            else
            {
                $artist2 = NULL;
            }
            if ($track->artist_3 != NULL)
            {
                $artist3 = $this->getArtistById($track->artist_3);
            }
            else
            {
                $artist3 = NULL;
            }

            $trackId = $track->id;
            $track_name_en = $track->track_name_en;

            if ($track_name_en == 'Where the Streets Have No Name' && $artist_1 = 'U2')
            {
                $tr = "<tr>
						<td><a href='/tracks/34/where_the_streets_have_no_name'><img src='/images/icons/baseline-translate-24px.svg' alt='' class='song-with-trans'><span class='song-name'>Where the Streets Have No Name</span> - <span class='song-artist'>U2</a></td>
					</tr>";
            }
            else
            {
                $track_name_en = strtolower($track_name_en);
                $tr = "<tr><td><a href='tracks/" . $trackId . "/" . str_replace(' ', '_', str_replace("'", "", $track_name_en)) . "'>";
                $tr .= "<span class='song-name'>";

                if ($track->track_name_ru)
                {
                    $tr .= $track->track_name_ru;
                }
                else
                {
                    $tr .= $track->track_name_en;
                }

                $tr .= "</span> - <span class='song-artist'>";

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
            }

            $trArray [] = $tr;
        }

        return view('tracks.index', [
            'title' => $title,
            'trArray' => $trArray]
        );
    }

    public function showTrack($trackId, $track_name_en)
    {
        $track = $this->getTrackById($trackId);
        $track = $track[0];
        if ($track->imageLyrics == 1)
        {
            $imageLink = "/images/songs/" . $track_name_en . ".jpg";
        }
        else
        {
            $imageLink = null;
        }
        $track_name_en = str_replace('.php', '', $track_name_en);
        $track_name_en = str_replace('_', ' ', $track_name_en);
        $track_name_en = ucwords($track_name_en);
        $lyrics = explode("\n", $track->lyrics);

        if ($track->artist_1 != NULL)
        {
            $artist1 = $this->getArtistById($track->artist_1);
        }
        if ($track->artist_2 != NULL)
        {
            $artist2 = $this->getArtistById($track->artist_2);
        }
        if ($track->artist_3 != NULL)
        {
            $artist3 = $this->getArtistById($track->artist_3);
        }

        if (!empty($artist2->artist_ru))
        {
            if (!empty($artist3->artist_ru))
            {
                $title = $track_name_en . ' - ' . $artist1->artist_ru . ', ' . $artist2->artist_ru . ', ' . $artist3->artist_ru;
            }
            else
            {
                $title = $track_name_en . ' - ' . $artist1->artist_ru . ', ' . $artist2->artist_ru;
            }
        }
        else
        {
            $title = $track_name_en . ' - ' . $artist1->artist_ru;
        }

        if ($track->imageLyrics)
        {
            if (!empty($artist2) and !empty($artist3))
            {
                return view('tracks.trackImageLyrics', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'artist3' => $artist3,
                    'imageLink' => $imageLink
                ]);
            }
            else if (!empty($artist2))
            {
                return view('tracks.trackImageLyrics', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'imageLink' => $imageLink
                ]);
            }
            else
            {
                return view('tracks.trackImageLyrics', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'imageLink' => $imageLink
                ]);
            }
        }
        else
        {
            if (!empty($artist2) and !empty($artist3))
            {
                return view('tracks.track', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'artist3' => $artist3,
                    'lyrics' => $lyrics
                ]);
            }
            else if (!empty($artist2))
            {
                return view('tracks.track', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'lyrics' => $lyrics
                ]);
            }
            else
            {
                return view('tracks.track', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'lyrics' => $lyrics
                ]);
            }
        }

    }

    public function whereTheStreetsHaveNoNameU2()
    {
        $title = 'Where the Streets Have No Name - U2';
        return view('tracks.whereTheStreetsHaveNoNameU2', ['title' => $title]);
    }

    public function add(Request $request)
    {
        $title = "Добавить трек";

        $artists = (new ArtistController())->getArtists();

        if ($request->isMethod('get'))
        {
            $msg = '';
            $msgClass = '';

            return view('tracks.add', [
                'title' => $title,
                'artists' => $artists,
                'msg' => $msg,
                'msgClass' => $msgClass
            ]);
        }
        else if ($request->isMethod('post'))
        {
            $this->validate($request, [
                'track_name_en' => 'required',
                'artist_1' => 'required',
                'lyrics' => 'required'
            ]);

            // Проверяем, не пусты ли необходимые поля.
            if (!empty($request['track_name_en']) and !empty($request['artist_1']) and !empty($request['lyrics']))
            {
                $track_name_en = $request['track_name_en'];
                $artist_1 = $request['artist_1'];
                $lyrics = $request['lyrics'];
                if (empty($request['artist_2']))
                {
                    $artist_2 = NULL;
                }
                else
                {
                    $artist_2 = $request['artist_2'];
                }
                if (empty($request['artist_3']))
                {
                    $artist_3 = NULL;
                }
                else
                {
                    $artist_3 = $request['artist_3'];
                }
                if (empty($request['spotify_link']))
                {
                    $spotify_link = NULL;
                }
                else
                {
                    $spotify_link = $request['spotify_link'];
                }
                if (empty($request['youtube_link']))
                {
                    $youtube_link = NULL;
                }
                else
                {
                    $youtube_link = $request['youtube_link'];
                }

                if (!empty($request['track_name_ru']))
                {
                    $track_name_ru = $request['track_name_ru'];
                }
                else
                {
                    $track_name_ru = $track_name_en;
                }

                // Проверяем, есть ли такой трек с исполнителями.
                $noMatches = true;
                $tracks = (new TrackController())->getTracks();
                foreach($tracks as $track)
                {
                    if ($artist_2 != NULL AND $artist_3 != NULL)
                    {
                        if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1 or $artist_2 == $track->artist_2 or $artist_3 == $track->artist_3) )
                        {
                            $noMatches = false;
                        }
                        else if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1 or $artist_2 == $track->artist_3 or $artist_3 == $track->artist_2) )
                        {
                            $noMatches = false;
                        }
                        else if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_2 or $artist_2 == $track->artist_1 or $artist_3 == $track->artist_3) )
                        {
                            $noMatches = false;
                        }
                        else if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_3 or $artist_2 == $track->artist_1 or $artist_3 == $track->artist_1) )
                        {
                            $noMatches = false;
                        }
                        else if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_2 or $artist_2 == $track->artist_3 or $artist_3 == $track->artist_1) )
                        {
                            $noMatches = false;
                        }
                        else if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_3 or $artist_2 == $track->artist_1 or $artist_3 == $track->artist_1) )
                        {
                            $noMatches = false;
                        }
                    }
                    else if ($artist_2 != NULL and $artist_3 == NULL)
                    {
                        if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1 or $artist_2 == $track->artist_2) )
                        {
                            $noMatches = false;
                        }
                        else if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_2 or $artist_2 == $track->artist_1) )
                        {
                            $noMatches = false;
                        }
                    }
                    else if ($artist_2 == NULL and $artist_3 == NULL)
                    {
                        if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1) )
                        {
                            $noMatches = false;
                        }
                    }

                    if ($spotify_link != NULL and $spotify_link == $track->spotify_link)
                    {
                        $noMatches = false;
                        $msg = 'Такая Spotify ссылка уже есть в базе';
                    }
                    if ($youtube_link != NULL and $youtube_link == $track->youtube_link)
                    {
                        $noMatches = false;
                        $msg = 'Такая YouTube ссылка уже есть в базе';
                    }
                }

                if ($noMatches)
                {
                    DB::table('tracks')->insert(
                        [
                            'track_name_en' => $track_name_en,
                            'track_name_ru' => $track_name_ru,
                            'artist_1' => $artist_1,
                            'artist_2' => $artist_2,
                            'artist_3' => $artist_3,
                            'lyrics' => $lyrics,
                            'spotify_link' => $spotify_link,
                            'youtube_link' => $youtube_link
                        ]
                    );

                    $msg = 'Трек добавлен';
                    $msgClass = 'alert-success';

                    return view('tracks.add', [
                        'title' => $title,
                        'artists' => $artists,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }
                else
                {
                    if (empty($msg))
                    {
                        $msg = 'Такая запись уже есть в базе';
                    }
                    $msgClass = 'alert-danger';

                    return view('tracks.add', [
                        'title' => $title,
                        'artists' => $artists,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }
            }
        }
    }

    public function delete(Request $request)
    {
        $title = 'Удалить трек';

        if ($request->isMethod('get'))
        {
            $msg = '';
            $msgClass = '';

            return view('tracks.delete', [
                'title' => $title,
                'tracks' => $this->getTracksWithArtistNames(),
                'msg' => $msg,
                'msgClass' => $msgClass
            ]);
        }
        else if ($request->isMethod('delete'))
        {
            $this->validate($request, [
                'track_id' => 'required',
            ]);

            if (!empty($request['track_id']))
            {
                $trackId = $request['track_id'];
                // Смотрим, есть ли трек, который пытаемся удалить, в таблице tracks.
                $trackExists = false;
                $tracks = $this->getTracks();
                foreach($tracks as $track)
                {
                    if ($trackId == $track->id) $trackExists = true;
                    else continue;
                }

                if ($trackExists)
                {
                    // Возвращает количество затронутых строк.
                    $deleted = DB::delete('delete from tracks where id = :id', ['id' => $trackId]);

                    if($deleted >= 1)
                    {
                        $msg = 'Запись удалена';
                        $msgClass = 'alert-success';

                        return view('tracks.delete', [
                            'title' => $title,
                            'tracks' => $this->getTracksWithArtistNames(),
                            'msg' => $msg,
                            'msgClass' => $msgClass
                        ]);
                    }
                    else
                    {
                        $msg = 'Не удалось удалить трек';
                        $msgClass = 'alert-danger';

                        return view('tracks.delete', [
                            'title' => $title,
                            'tracks' => $this->getTracksWithArtistNames(),
                            'msg' => $msg,
                            'msgClass' => $msgClass
                        ]);
                    }
                }
                else
                {
                    $msg = 'Такого трека нет в базе';
                    $msgClass = 'alert-danger';

                    return view('tracks.delete', [
                        'title' => $title,
                        'tracks' => $this->getTracksWithArtistNames(),
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }
            }
        }
    }
}
