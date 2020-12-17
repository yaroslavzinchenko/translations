<?php

#use Illuminate\Support\Facades\Route;

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


if (session_status() != PHP_SESSION_DISABLED and session_status() == PHP_SESSION_NONE)
{
    session_start();
}
/*print_r(session_status());
print_r($_SESSION);*/

# Get the currently authenticated user's name.
$username = isset($_SESSION['username']) ? strtolower($_SESSION['username']) : "yaroslavzinchenko";

/*$routeHome = $userId == '' ? "users/1/tracks" : "users/$userId/tracks";
Route::redirect('/', $routeHome);*/


Route::get("/", 'WelcomeController@index');

Route::redirect('/tracks', "/user/{$username}/tracks");
Route::get("/user/{username}/tracks", 'TrackController@index');

Route::get('/user/yaroslavzinchenko/tracks/34/where_the_streets_have_no_name', 'TrackController@whereTheStreetsHaveNoNameU2');


Route::redirect('/artists', "/user/{$username}/artists");
Route::get('/user/{username}/artists', 'ArtistController@index');

Route::get('/user/{username}/artists/{artistId}/{artist}', 'ArtistController@showArtistSongs');


# Edit.

Route::get('/edit', 'EditController@index');

Route::match(['get', 'post'], '/artists/add', 'ArtistController@add');

Route::match(['get', 'post'], '/tracks/add', 'TrackController@add');

Route::match(['get', 'patch'], '/artists/edit', 'ArtistController@edit');

Route::get('/tracks/edit', 'TrackController@edit');
Route::match(['get', 'patch'], '/tracks/edit/{id}/', 'TrackController@editById');
Route::get('/user/{username}/tracks/{id}/{track_name}', 'TrackController@showTrack');


Route::get('/games/doom', 'GameController@doom');

// Delete.

Route::match(['get', 'delete'], '/artists/delete/', 'ArtistController@delete');

Route::match(['get', 'delete'], '/tracks/delete/', 'TrackController@delete');

# Auth.

Route::match(['get', 'post'], '/login', 'AuthController@login');
Route::get( '/logout', 'AuthController@logout');
Route::match(['get', 'post'], '/signup', 'AuthController@signup');
Route::match(['get', 'post'], '/forgot-password', 'AuthController@forgotPassword');
Route::match(['get', 'post'], '/verify-email', 'AuthController@verifyEmail');
Route::get('/check-verification-code-sent-at', 'AuthController@checkVerificationCodeSentAt');


