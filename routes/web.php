<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::redirect('/', '/tracks');

Route::get('/tracks', 'TrackController@index');

Route::get('/tracks/add', 'TrackController@add');

Route::get('/artists', 'ArtistController@index');

Route::redirect('/games', '/games/doom');

Route::get('/games/doom', 'GameController@doom');


