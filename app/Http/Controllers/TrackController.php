<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    public function index()
    {
        $title = "Главная страница";
        $tracks =DB::select('SELECT DISTINCT
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

        $trArray = [];
        foreach($tracks as $track)
        {
            $track_name = $track->track_name;
            $artist_1 = $track->artist_1;

            if ($track_name == 'Where the Streets Have No Name' && $artist_1 = 'U2')
            {
                $tr = "<tr>
						<td><a href='/tracks/where_the_streets_have_no_name.php'><img src='/images/icons/baseline-translate-24px.svg' alt='' class='song-with-trans'><span class='song-name'>Where the Streets Have No Name</span> - <span class='song-artist'>U2</a></td>
					</tr>";
            }
            else
            {
                $track_name = strtolower($track_name);
                $tr = "<tr><td><a href='tracks/" . str_replace(' ', '_', str_replace("'", "", $track_name)) . ".php'>";
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

    public function add()
    {
        $title = "Добавить трек";
        return view('tracks.add', ['title' => $title]);
    }
}
