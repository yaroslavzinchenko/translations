<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    private function getTracks()
    {
        $tracks = DB::select('SELECT DISTINCT
                                        id,
                                        track_name,
										track_name_ru,
										artist_1,
										artist_1_ru,
										artist_2,
										artist_2_ru,
										artist_3,
										artist_3_ru
							FROM tracks
							ORDER BY track_name_ru');

        return $tracks;
    }

    private function getTrack($id)
    {
        $track = DB::table('tracks')->where('id', '=', $id)->get();
        return $track;
    }

    public function index()
    {
        $title = "Главная страница";

        $tracks = $this->getTracks();

        $trArray = [];
        foreach($tracks as $track)
        {
            $id = $track->id;
            $track_name = $track->track_name;

            if ($track_name == 'Where the Streets Have No Name' && $artist_1 = 'U2')
            {
                $tr = "<tr>
						<td><a href='/tracks/34/where_the_streets_have_no_name'><img src='/images/icons/baseline-translate-24px.svg' alt='' class='song-with-trans'><span class='song-name'>Where the Streets Have No Name</span> - <span class='song-artist'>U2</a></td>
					</tr>";
            }
            else
            {
                $track_name = strtolower($track_name);
                $tr = "<tr><td><a href='tracks/" . $id . "/" . str_replace(' ', '_', str_replace("'", "", $track_name)) . "'>";
                $tr .= "<span class='song-name'>";

                if ($track->track_name_ru)
                {
                    $tr .= $track->track_name_ru;
                }
                else
                {
                    $tr .= $track->track_name;
                }

                $tr .= "</span> - <span class='song-artist'>";

                if ($track->artist_1_ru)
                {
                    $tr .= $track->artist_1_ru;
                }
                else
                {
                    $tr .= $track->artist_1;
                }

                if ($track->artist_2_ru and $track->artist_2_ru !== null)
                {
                    $tr .= ', ' . $track->artist_2_ru;
                }
                else if ($track->artist_2 and $track->artist_2 !== null)
                {
                    $tr .= ', ' . $track->artist_2;
                }

                if ($track->artist_3_ru and $track->artist_3_ru !== null)
                {
                    $tr .= ', ' . $track->artist_3_ru;
                }
                else if ($track->artist_3 and $track->artist_3 !== null)
                {
                    $tr .= ', ' . $track->artist_3;
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

    public function showTrack($id, $track_name)
    {
        $track = $this->getTrack($id);
        $track = $track[0];
        $track_name = str_replace('.php', '', $track_name);
        $track_name = str_replace('_', ' ', $track_name);
        $track_name = ucwords($track_name);
        $lyrics = explode("\n", $track->lyrics);

        if (!empty($track->artist_2_ru))
        {
            if (!empty($track->artist_3_ru))
            {
                $title = $track_name . ' - ' . $track->artist_1_ru . ', ' . $track->artist_2_ru . ', ' . $track->artist_3_ru;
            }
            else
            {
                $title = $track_name . ' - ' . $track->artist_1_ru . ', ' . $track->artist_2_ru;
            }
        }
        else
        {
            $title = $track_name . ' - ' . $track->artist_1_ru;
        }

        return view('tracks.track', [
            'title' => $title,
            'track' => $track,
            'lyrics' => $lyrics
        ]);
    }

    public function whereTheStreetsHaveNoNameU2()
    {
        $title = 'Where the Streets Have No Name - U2';
        return view('tracks.whereTheStreetsHaveNoNameU2', ['title' => $title]);
    }

    public function add()
    {
        $title = "Добавить трек";
        return view('tracks.add', ['title' => $title]);
    }
}
