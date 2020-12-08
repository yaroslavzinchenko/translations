<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public static function getTracksByUserId(int $userId): array
    {
        $tracks = DB::select("
                                    SELECT *
                                    FROM tracks
                                    WHERE user_id_fk = $userId
                                    ORDER BY track_name_ru
                                    ");

        return $tracks;
    }

    public static function getTrackOwnerIdByTrackId(int $trackId): int
    {
        $ownerId = DB::table('tracks')
            ->select('user_id_fk')
            ->where('id', '=', $trackId)
            ->limit(1)
            ->get();
        $ownerId = $ownerId[0]->user_id_fk;
        return $ownerId;
    }

    public function getTracksWithArtistNamesByUserId(int $userId)
    {
        $tracks = DB::select
        ("
            WITH t1 AS
            (
                SELECT id AS artist_id,
                artist_en,
                artist_ru,
                add_time,
                user_id_fk
                FROM artists
                WHERE user_id_fk = :user_id_fk1
            ),
            t2 AS
            (
                SELECT * FROM tracks
                WHERE user_id_fk = :user_id_fk2
            )
            SELECT * FROM t2
            INNER JOIN t1
            ON t2.ARTIST_1 = t1.artist_id
            ORDER BY track_name_ru
            ", ['user_id_fk1' => $userId, 'user_id_fk2' => $userId]
        );

        return $tracks;
    }

    private function getTrackById($trackId)
    {
        $track = DB::table('tracks')->where('id', '=', $trackId)->get();
        return $track;
    }
    private function getTrackOwnerNameByTrackId($trackId)
    {
        $trackOwnerName = DB::select('
                            SELECT users.username FROM tracks
                            INNER JOIN users
                            ON tracks.user_id_fk = users.id
                            WHERE tracks.id = :trackId
                            ', ['trackId' => $trackId]);
        $trackOwnerName = $trackOwnerName[0]->username;
        return $trackOwnerName;
    }

    public function index($username)
    {
        $title = "Треки";

        $userId = UserController::getUserIdByUsername($username);
        $tracks = $this->getTracksByUserId($userId);
        $trArray = [];

        foreach($tracks as $track) {
            if ($track->artist_1 != NULL) {
                $artist1 = ArtistController::getArtistById($track->artist_1);
            }
            if ($track->artist_2 != NULL) {
                $artist2 = ArtistController::getArtistById($track->artist_2);
            } else {
                $artist2 = NULL;
            }
            if ($track->artist_3 != NULL) {
                $artist3 = ArtistController::getArtistById($track->artist_3);
            } else {
                $artist3 = NULL;
            }

            $trackId = $track->id;
            $track_name_en = $track->track_name_en;

            if ($track_name_en == 'Where the Streets Have No Name' && $artist_1 = 'U2') {
                $tr = "<tr>
						<td><a href='tracks/34/where_the_streets_have_no_name'><img src='/images/icons/baseline-translate-24px.svg' alt='' class='song-with-trans'><span class='song-name'>Where the Streets Have No Name</span> - <span class='song-artist'>U2</a></td>
					</tr>";
            } else {
                $track_name_en = strtolower($track_name_en);
                $tr = "<tr><td><a href='tracks/" . $trackId . "/" . str_replace(' ', '_', str_replace("'", "", $track_name_en)) . "'>";
                $tr .= "<span class='song-name'>";

                if ($track->track_name_ru) {
                    $tr .= $track->track_name_ru;
                } else {
                    $tr .= $track->track_name_en;
                }

                $tr .= "</span> - <span class='song-artist'>";

                if (!empty($artist1->artist_ru)) {
                    $tr .= $artist1->artist_ru;
                } else {
                    $tr .= $artist1->artist_en;
                }
                if (!empty($artist2->artist_ru))
                {
                    $tr .= ', ' . $artist2->artist_ru;
                } elseif (!empty($artist2->artist_en)) {
                    $tr .= ', ' . $artist2->artist_en;
                }
                if (!empty($artist3->artist_ru)) {
                    $tr .= ', ' . $artist3->artist_ru;
                }
                elseif (!empty($artist3->artist_en)) {
                    $tr .= ', ' . $artist3->artist_en;
                }

                $tr .= "</span></a></td></tr>";
            }

            $trArray [] = $tr;
        }

        return view('tracks.index', [
            'title' => $title,
            'trArray' => $trArray]
        );
    }

    public function showTrack($username, $trackId, $track_name_en)
    {
        $trackOwner = $this->getTrackOwnerNameByTrackId($trackId);
        if (strtoupper($trackOwner) != strtoupper($username)) {
            abort(404);
        }

        $track = $this->getTrackById($trackId);
        $track = $track[0];
        if ($track->imageLyrics == 1) {
            $imageLink = "/images/songs/" . $track_name_en . ".jpg";
        } else {
            $imageLink = null;
        }
        $track_name_en = str_replace('.php', '', $track_name_en);
        $track_name_en = str_replace('_', ' ', $track_name_en);
        $track_name_en = ucwords($track_name_en);
        $lyrics = explode("\n", $track->lyrics);

        if ($track->artist_1 != NULL) {
            $artist1 = ArtistController::getArtistById($track->artist_1);
        }
        if ($track->artist_2 != NULL) {
            $artist2 = ArtistController::getArtistById($track->artist_2);
        }
        if ($track->artist_3 != NULL) {
            $artist3 = ArtistController::getArtistById($track->artist_3);
        }

        if (!empty($artist2->artist_ru)) {
            if (!empty($artist3->artist_ru)) {
                $title = $track_name_en . ' - ' . $artist1->artist_ru . ', ' . $artist2->artist_ru . ', ' . $artist3->artist_ru;
            } else {
                $title = $track_name_en . ' - ' . $artist1->artist_ru . ', ' . $artist2->artist_ru;
            }
        } else {
            $title = $track_name_en . ' - ' . $artist1->artist_ru;
        }

        if ($track->imageLyrics) {
            if (!empty($artist2) and !empty($artist3)) {
                return view('tracks.trackImageLyrics', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'artist3' => $artist3,
                    'imageLink' => $imageLink
                ]);
            }
            elseif (!empty($artist2)) {
                return view('tracks.trackImageLyrics', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'imageLink' => $imageLink
                ]);
            } else {
                return view('tracks.trackImageLyrics', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'imageLink' => $imageLink
                ]);
            }
        } else {
            if (!empty($artist2) and !empty($artist3)) {
                return view('tracks.track', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'artist3' => $artist3,
                    'lyrics' => $lyrics
                ]);
            } elseif (!empty($artist2)) {
                return view('tracks.track', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'lyrics' => $lyrics
                ]);
            } else {
                return view('tracks.track', [
                    'title' => $title,
                    'track' => $track,
                    'artist1' => $artist1,
                    'lyrics' => $lyrics
                ]);
            }
        }

    }

    public function whereTheStreetsHaveNoNameU2()
    {
        $title = 'Where the Streets Have No Name - U2';
        return view('tracks.whereTheStreetsHaveNoNameU2', ['title' => $title]);
    }

    public function add(Request $request)
    {
        if (AuthController::checkIfUserLoggedIn() === 1) {
            $currentUserId = $_SESSION['userId'];
        } else {
            $_SESSION['warning'] = "You are not logged in.";
            header('Location: /login');
            exit();
        }
        if (AuthController::checkIfUserVerified() !== 1) {
            $_SESSION['warning'] = "Email is not verified yet.";
            header('Location: /verify-email');
            exit();
        }

        $title = "Добавить трек";

        $artists = ArtistController::getArtistsByUserId($currentUserId);

        if ($request->isMethod('get')) {
            $msg = '';
            $msgClass = '';

            return view('tracks.add', [
                'title' => $title,
                'artists' => $artists,
                'msg' => $msg,
                'msgClass' => $msgClass
            ]);
        }
        elseif ($request->isMethod('post')) {
            $this->validate($request, [
                'track_name_en' => 'required',
                'artist_1' => 'required',
                'lyrics' => 'required',
                'userIdFromForm' => 'required',
            ]);

            # Проверяем, не пусты ли необходимые поля.
            if (!empty($request['track_name_en']) and !empty($request['artist_1']) and !empty($request['lyrics']) and !empty($request['userIdFromForm'])) {
                # Если пользователь, отправивший форму, не совпадает с текущим авторизованным пользователем, прерываем выполнение.
                if ($currentUserId != $request['userIdFromForm']) {
                    $msg = 'Вы зашли под другим пользователем.';
                    $msgClass = 'alert-danger';
                    return view('tracks.add', [
                        'title' => $title,
                        'artists' => $artists,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }

                $track_name_en = $request['track_name_en'];
                $artist_1 = $request['artist_1'];
                $lyrics = $request['lyrics'];
                if (empty($request['artist_2'])) {
                    $artist_2 = NULL;
                }
                else {
                    $artist_2 = $request['artist_2'];
                }
                if (empty($request['artist_3'])) {
                    $artist_3 = NULL;
                } else
                {
                    $artist_3 = $request['artist_3'];
                }
                if (empty($request['spotify_link']))
                {
                    $spotify_link = NULL;
                } else {
                    $spotify_link = $request['spotify_link'];
                }
                if (empty($request['youtube_link'])) {
                    $youtube_link = NULL;
                } else {
                    $youtube_link = $request['youtube_link'];
                }

                if (!empty($request['track_name_ru'])) {
                    $track_name_ru = $request['track_name_ru'];
                } else {
                    $track_name_ru = $track_name_en;
                }


                # Проверяем, нет введены ли одинаковые исполнители.
                if ($artist_2 != NULL AND $artist_3 != NULL) {
                    if ($artist_1 === $artist_2 or $artist_1 === $artist_3 or $artist_2 === $artist_3) {
                        $msg = 'Вы указали одного исполнителя 2 или более раз.';
                        $msgClass = 'alert-danger';
                        return view('tracks.add', [
                            'title' => $title,
                            'artists' => $artists,
                            'msg' => $msg,
                            'msgClass' => $msgClass,
                        ]);
                    }
                } elseif ($artist_2 != NULL and $artist_3 == NULL) {
                    if ($artist_1 === $artist_2) {
                        $msg = 'Первый и второй исполнители совпадают.';
                        $msgClass = 'alert-danger';
                        return view('tracks.add', [
                            'title' => $title,
                            'artists' => $artists,
                            'msg' => $msg,
                            'msgClass' => $msgClass,
                        ]);
                    }
                }


                # Проверяем, есть ли такой трек с исполнителями.
                $noMatches = true;
                $tracks = $this->getTracksByUserId($currentUserId);
                foreach($tracks as $track) {
                    if ($artist_2 != NULL AND $artist_3 != NULL) {
                        if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1 or $artist_2 == $track->artist_2 or $artist_3 == $track->artist_3) ) {
                            $noMatches = false;
                        } elseif ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1 or $artist_2 == $track->artist_3 or $artist_3 == $track->artist_2) ) {
                            $noMatches = false;
                        } elseif ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_2 or $artist_2 == $track->artist_1 or $artist_3 == $track->artist_3) ) {
                            $noMatches = false;
                        } elseif ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_3 or $artist_2 == $track->artist_1 or $artist_3 == $track->artist_1) ) {
                            $noMatches = false;
                        } elseif ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_2 or $artist_2 == $track->artist_3 or $artist_3 == $track->artist_1) ) {
                            $noMatches = false;
                        } elseif ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_3 or $artist_2 == $track->artist_1 or $artist_3 == $track->artist_1) ) {
                            $noMatches = false;
                        }
                    } elseif ($artist_2 != NULL and $artist_3 == NULL) {
                        if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1 or $artist_2 == $track->artist_2) ) {
                            $noMatches = false;
                        } elseif ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_2 or $artist_2 == $track->artist_1) ) {
                            $noMatches = false;
                        }
                    } elseif ($artist_2 == NULL and $artist_3 == NULL) {
                        if ( (strtoupper($track_name_en) == strtoupper($track->track_name_en) or strtoupper($track_name_ru) == strtoupper($track->track_name_ru)) AND ($artist_1 == $track->artist_1) ) {
                            $noMatches = false;
                        }
                    }

                    if ($spotify_link != NULL and $spotify_link == $track->spotify_link) {
                        $noMatches = false;
                        $msg = 'Такая Spotify ссылка уже есть в базе';
                    }
                    if ($youtube_link != NULL and $youtube_link == $track->youtube_link) {
                        $noMatches = false;
                        $msg = 'Такая YouTube ссылка уже есть в базе';
                    }
                }

                if ($noMatches) {
                    $inserted = DB::table('tracks')->insert(
                        [
                            'track_name_en' => $track_name_en,
                            'track_name_ru' => $track_name_ru,
                            'artist_1' => $artist_1,
                            'artist_2' => $artist_2,
                            'artist_3' => $artist_3,
                            'lyrics' => $lyrics,
                            'spotify_link' => $spotify_link,
                            'youtube_link' => $youtube_link,
                            'user_id_fk' => $currentUserId,
                        ]
                    );

                    if ($inserted) {
                        $msg = 'Трек добавлен.';
                        $msgClass = 'alert-success';
                    } else {
                        $msg = 'Ошибка при добавлении трека.';
                        $msgClass = 'alert-danger';
                    }

                    return view('tracks.add', [
                        'title' => $title,
                        'artists' => $artists,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                } else {
                    if (empty($msg)) {
                        $msg = 'Такая запись уже есть в базе';
                    }
                    $msgClass = 'alert-danger';

                    return view('tracks.add', [
                        'title' => $title,
                        'artists' => $artists,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }
            }
        }
    }

    # Функция, принимающая на вход id пользователя и возвращающая массив для шаблона edit, содержащий все треки.
    public static function makeEditTracksTrArray(int $userId): array
    {
        $tracks = TrackController::getTracksByUserId($userId);
        $trArray = array();

        foreach($tracks as $track)
        {
            if ($track->artist_1 != NULL)
            {
                $artist1 = ArtistController::getArtistById($track->artist_1);
            }
            if ($track->artist_2 != NULL)
            {
                $artist2 = ArtistController::getArtistById($track->artist_2);
            }
            else
            {
                $artist2 = NULL;
            }
            if ($track->artist_3 != NULL)
            {
                $artist3 = ArtistController::getArtistById($track->artist_3);
            }
            else
            {
                $artist3 = NULL;
            }

            $trackId = $track->id;
            $track_name_en = $track->track_name_en;

            $track_name_en = strtolower($track_name_en);
            $tr = "<tr><td><a href='edit/" . $trackId . "'>";
            $tr .= "<img src='/images/icons/pencil.png' alt='' class='song-with-icon'>";
            $tr .= "<span class='song-name'>";

            if ($track->track_name_ru)
            {
                $tr .= $track->track_name_ru;
            }
            else
            {
                $tr .= $track->track_name_en;
            }

            $tr .= "</span> - <span class='song-artist'>";

            if (!empty($artist1->artist_ru)) {
                $tr .= $artist1->artist_ru;
            }
            else {
                $tr .= $artist1->artist_en;
            }
            if (!empty($artist2->artist_ru)) {
                $tr .= ', ' . $artist2->artist_ru;
            }
            else if (!empty($artist2->artist_en)) {
                $tr .= ', ' . $artist2->artist_en;
            }
            if (!empty($artist3->artist_ru)) {
                $tr .= ', ' . $artist3->artist_ru;
            }
            elseif (!empty($artist3->artist_en)) {
                $tr .= ', ' . $artist3->artist_en;
            }

            $tr .= "</span></a></td></tr>";

            $trArray[] = $tr;
        }

        return $trArray;
    }

    public function edit(Request $request)
    {
        if (AuthController::checkIfUserLoggedIn() === 1) {
            $currentUserId = $_SESSION['userId'];
        } else {
            $_SESSION['warning'] = "You are not logged in.";
            header('Location: /login');
            exit();
        }
        if (AuthController::checkIfUserVerified() !== 1) {
            $_SESSION['warning'] = "Email is not verified yet.";
            header('Location: /verify-email');
            exit();
        }

        $title = "Изменить треки";

        $trArray = $this->makeEditTracksTrArray($currentUserId);

        $msg = '';
        $msgClass = '';
        return view('tracks.edit', [
                'title' => $title,
                'msg' => $msg,
                'msgClass' => $msgClass,
                'trArray' => $trArray,
            ]
        );
    }

    public function editById($trackId, Request $request)
    {
        if (AuthController::checkIfUserLoggedIn() === 1) {
            $currentUserId = $_SESSION['userId'];
            $trackOwnerId = $this->getTrackOwnerIdByTrackId((int) $trackId);
        } else {
            $_SESSION['warning'] = "You are not logged in.";
            header('Location: /login');
            exit();
        }
        if (AuthController::checkIfUserVerified() !== 1) {
            $_SESSION['warning'] = "Email is not verified yet.";
            header('Location: /verify-email');
            exit();
        }

        $title = "Изменить трек";

        $artists = ArtistController::getArtistsByUserId($currentUserId);
        $track = $this->getTrackById($trackId);
        $track = $track[0];

        $artist1 = ArtistController::getArtistById($track->artist_1);
        if ($track->artist_2 != NULL) {
            $artist2 = ArtistController::getArtistById($track->artist_2);
        } else {
            $artist2 = NULL;
        }

        if ($track->artist_3 != NULL) {
            $artist3 = ArtistController::getArtistById($track->artist_3);
        } else {
            $artist3 = NULL;
        }

        if ($request->isMethod('get')) {
            $msg = '';
            $msgClass = '';

            return view('tracks.editById', [
                'title' => $title,
                'artists' => $artists,
                'artist1' => $artist1,
                'artist2' => $artist2,
                'artist3' => $artist3,
                'track' => $track,
                'msg' => $msg,
                'msgClass' => $msgClass,
                'trackOwnerId' => $trackOwnerId,
            ]);
        }
        if ($request->isMethod('patch')) {
            $this->validate($request, [
                'track_name_en' => 'required',
                'track_name_ru' => 'required',
                'artist_1' => 'required',
                'lyrics' => 'required',
                'userIdFromForm' => 'required',
            ]);

            $track_name_en = $request['track_name_en'];
            $track_name_ru = $request['track_name_ru'];
            $artist_1 = $request['artist_1'];
            $artist_2 = empty($request['artist_2']) ? NULL : $request['artist_2'];
            $artist_3 = empty($request['artist_3']) ? NULL : $request['artist_3'];
            $lyrics = $request['lyrics'];
            $spotify_link = $request['spotify_link'];
            $youtube_link = $request['youtube_link'];

            if (!empty($request['track_name_en']) and !empty($request['track_name_ru']) and !empty($request['artist_1']) and !empty($request['lyrics'])) {
                # Если пользователь, отправивший форму, не совпадает с текущим авторизованным пользователем, прерываем выполнение.
                if ($currentUserId != $request['userIdFromForm']) {
                    $_SESSION['error'] = 'Вы зашли под другим пользователем.';
                    header('Location: /tracks/edit');
                    exit();
                }

                $noChanges = false;
                $tracks = $this->getTracksByUserId($currentUserId);
                foreach($tracks as $track) {
                    if
                    (
                        (strtoupper($track_name_en) == strtoupper($track->track_name_en))
                        and
                        (strtoupper($track_name_ru) == strtoupper($track->track_name_ru))
                        and
                        ($artist_1 == $track->artist_1)
                        and
                        ($artist_2 == $track->artist_2)
                        and
                        ($lyrics == $track->lyrics)
                        and
                        ($spotify_link == $track->spotify_link)
                        and
                        ($youtube_link == $track->youtube_link)
                    )
                    {
                        $noChanges = true;
                    }
                }

                if ($noChanges) {
                    $msg = "Изменений нет.";
                    $msgClass = 'alert-danger';
                }
                else {
                    if ($lyrics == "") {
                        $msg = "Нет текста.";
                        $msgClass = 'alert-danger';

                        return view('tracks.editById', [
                            'title' => $title,
                            'artists' => $artists,
                            'artist1' => $artist1,
                            'artist2' => $artist2,
                            'artist3' => $artist3,
                            'track' => $track,
                            'msg' => $msg,
                            'msgClass' => $msgClass,
                            'trackOwnerId' => $trackOwnerId,
                        ]);
                    }

                        $affected = DB::table('tracks')
                            ->where('id', $trackId)
                            ->update([
                                'track_name_en' => $track_name_en,
                                'track_name_ru' => $track_name_ru,
                                'artist_1' => ($artist_1 == NULL ? NULL : $artist_1),
                                'artist_2' => ($artist_2 == NULL ? NULL : $artist_2),
                                'artist_3' => ($artist_3 == NULL ? NULL : $artist_3),
                                'lyrics' => ($lyrics == NULL ? NULL : $lyrics),
                                'spotify_link' => ($spotify_link == NULL ? NULL : $spotify_link),
                                'youtube_link' => ($youtube_link == NULL ? NULL : $youtube_link),
                            ]);


                    $msg = "Трек изменён. В базе данных затронуто записей: $affected.";
                    $msgClass = 'alert-success';
                }

                $track = $this->getTrackById($trackId);
                $track = $track[0];

                $artist1 = ArtistController::getArtistById($track->artist_1);
                if ($track->artist_2 != NULL)
                { $artist2 = ArtistController::getArtistById($track->artist_2); } else $artist2 = NULL;

                if ($track->artist_3 != NULL)
                { $artist3 = ArtistController::getArtistById($track->artist_3); } else $artist3 = NULL;

                return view('tracks.editById', [
                    'title' => $title,
                    'artists' => $artists,
                    'artist1' => $artist1,
                    'artist2' => $artist2,
                    'artist3' => $artist3,
                    'track' => $track,
                    'msg' => $msg,
                    'msgClass' => $msgClass,
                    'trackOwnerId' => $trackOwnerId,
                ]);
            }
        }
    }

    public function delete(Request $request)
    {
        if (AuthController::checkIfUserLoggedIn() === 1) {
            $currentUserId = $_SESSION['userId'];
        } else {
            $_SESSION['warning'] = "You are not logged in.";
            header('Location: /login');
            exit();
        }
        if (AuthController::checkIfUserVerified() !== 1) {
            $_SESSION['warning'] = "Email is not verified yet.";
            header('Location: /verify-email');
            exit();
        }

        $title = 'Удалить трек';

        if ($request->isMethod('get')) {
            $msg = '';
            $msgClass = '';

            return view('tracks.delete', [
                'title' => $title,
                'tracks' => $this->getTracksWithArtistNamesByUserId($currentUserId),
                'msg' => $msg,
                'msgClass' => $msgClass,
            ]);
        }
        elseif ($request->isMethod('delete')) {
            $this->validate($request, [
                'track_id' => 'required',
                'userIdFromForm' => 'required',
            ]);

            if (!empty($request['track_id']) and !empty($request['userIdFromForm'])) {
                $trackId = $request['track_id'];
                $userIdFromForm = $request['userIdFromForm'];

                # Если пользователь, отправивший форму, не совпадает с текущим авторизованным пользователем, прерываем выполнение.
                if ($currentUserId != $request['userIdFromForm']) {
                    return view('tracks.delete', [
                        'title' => $title,
                        'tracks' => $this->getTracksWithArtistNamesByUserId($currentUserId),
                        'msg' => 'Вы зашли под другим пользователем.',
                        'msgClass' => 'alert-danger',
                    ]);
                }

                # Если пользователь, отправивший форму, не является владельцем трека, прерываем выполнение.
                if ($request['userIdFromForm'] != $this->getTrackOwnerIdByTrackId((int) $trackId)) {
                    return view('tracks.delete', [
                        'title' => $title,
                        'tracks' => $this->getTracksWithArtistNamesByUserId($currentUserId),
                        'msg' => 'Вы не владелец этого трека.',
                        'msgClass' => 'alert-danger',
                    ]);
                }

                # Смотрим, есть ли трек, который пытаемся удалить, в таблице tracks.
                $trackExists = false;
                $tracks = $this->getTracksByUserId($currentUserId);
                foreach($tracks as $track) {
                    if ($trackId == $track->id) $trackExists = true;
                    else continue;
                }

                if ($trackExists) {
                    # Возвращает количество затронутых строк.
                    $deleted = DB::delete('DELETE FROM tracks WHERE id = :id', ['id' => $trackId]);

                    if($deleted >= 1) {
                        return view('tracks.delete', [
                            'title' => $title,
                            'tracks' => $this->getTracksWithArtistNamesByUserId($currentUserId),
                            'msg' => 'Запись удалена.',
                            'msgClass' => 'alert-success',
                        ]);
                    }
                    else {
                        return view('tracks.delete', [
                            'title' => $title,
                            'tracks' => $this->getTracksWithArtistNamesByUserId($currentUserId),
                            'msg' => 'Не удалось удалить трек',
                            'msgClass' => 'alert-danger',
                        ]);
                    }
                }
                else {
                    return view('tracks.delete', [
                        'title' => $title,
                        'tracks' => $this->getTracksWithArtistNamesByUserId($currentUserId),
                        'msg' => 'Такого трека нет в базе',
                        'msgClass' => 'alert-danger',
                    ]);
                }
            }
        }
    }
}
