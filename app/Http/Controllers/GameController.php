<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function doom()
    {
        if (AuthController::checkIfUserLoggedIn() === 1) {
            if ($_SESSION['username'] === 'yaroslavzinchenko') {
                $title = "DOOM. Заветы Палача";
                return view('games.doom', [
                    'title' => $title,
                ]);
            } else {
                return view('errors.404', [

                ]);
            }
        }
        abort(404);
    }
}
