<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
{
    public function index()
    {
        $title = "Редактировать";

        return view('edit.index',[
            'title' => $title,
        ]);
    }
}
