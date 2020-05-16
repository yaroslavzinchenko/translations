<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        $title = "Исполнители";
        return view('artists.index', ['title' => $title]);
    }
}
