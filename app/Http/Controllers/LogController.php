<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    # Журналирование посещений.
    public static function logUserAction(string $route, string $action): void {
        date_default_timezone_set("Europe/Moscow");

        DB::table('users_logs')->insert(
            [
                # null - то есть пользователь не авторизован.
                'user_id_fk' => (!empty($_SESSION['userId']) and isset($_SESSION['userId'])) ? $_SESSION['userId'] : null,
                'route' => $route,
                'action' => $action,
                'performed_at' => date('Y-m-d H:i:s'),
            ]
        );


    }
}
