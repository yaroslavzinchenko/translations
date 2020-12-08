<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public static function getUserIdByUsername($username)
    {
        $username = strtoupper($username);
        $userId = DB::select("
                                    SELECT id
                                    FROM users
                                    WHERE username = '$username'
                                    LIMIT 1
                                    ");
        $userId = $userId[0]->id;
        return $userId;
    }
}
