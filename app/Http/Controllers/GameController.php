<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function doom()
    {
        $title = "DOOM. Заветы Палача";
        return view('games.doom', ['title' => $title]);
    }
}
