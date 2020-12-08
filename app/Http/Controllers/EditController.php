<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
{
    public function index()
    {
        if (AuthController::checkIfUserLoggedIn() !== 1) {
            $_SESSION['warning'] = "You are not logged in.";
            header('Location: /login');
            exit();
        }
        if (AuthController::checkIfUserVerified() !== 1) {
            $_SESSION['warning'] = "You are not verified.";
            header('Location: /verify-email');
            exit();
        }

        $title = "Редактировать";

        return view('edit.index', [
            'title' => $title,
        ]);
    }
}
