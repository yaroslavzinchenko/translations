<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $songs =DB::select('SELECT DISTINCT
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

        return view('index', ['songs' => $songs]);
    }
}
