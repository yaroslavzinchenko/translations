<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        LogController::logUserAction('/');

        $title = "Добро пожаловать";
        return view('welcome.index', [
            'title' => $title,
            ]
        );
    }
}
