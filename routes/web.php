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

Route::get('/tracks/34/where_the_streets_have_no_name', 'TrackController@whereTheStreetsHaveNoNameU2');

Route::get('/tracks/{id}/{track_name}', 'TrackController@showTrack');

Route::get('/artists', 'ArtistController@index');

Route::get('/artists/{artistId}/{artist}', 'ArtistController@showArtistSongs');


// Edit.

Route::get('/edit', 'EditController@index');

Route::match(['get', 'post'], '/artists/add', 'ArtistController@add');

Route::match(['get', 'post'], '/tracks/add', 'TrackController@add');

Route::match(['get', 'post'], '/artists/edit', 'ArtistController@edit');

Route::redirect('/games', '/games/doom');

Route::get('/games/doom', 'GameController@doom');

// Delete.

Route::match(['get', 'delete'], '/artists/delete/', 'ArtistController@delete');

Route::match(['get', 'delete'], '/tracks/delete/', 'TrackController@delete');


