<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function index()
    {
        LogController::logUserAction('/', 'visit');

        $title = "Добро пожаловать";
        return view('welcome.index', [
                'title' => $title,
            ]
        );
    }
}
