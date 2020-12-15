<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{
    public static function getArtistsByUserId(int $userId)
    {
        $artists = DB::table('artists')
            ->select('id', 'artist_en', 'artist_ru')
            ->where('user_id_fk', '=', $userId)
            ->orderBy('artist_ru', 'asc')
            ->get();

        return $artists;
    }

    public function getArtistTracksById($artistId)
    {
        $artistTracks = DB::select("
                                SELECT * FROM tracks
                                WHERE
                                artist_1 = " . $artistId . "
                                OR
                                artist_2 = " . $artistId . "
                                OR
                                artist_3 = " . $artistId . "
                                ORDER BY track_name_ru
                                ");
        return $artistTracks;
    }

    # Возвращает количество песен исполнителя.
    private function getArtistTracksNumberById($artistId)
    {
        $tracksNumber = DB::select("
                                SELECT COUNT(*) AS tracks_number FROM tracks
                                WHERE
                                artist_1 = $artistId
                                OR
                                artist_2 = $artistId
                                OR
                                artist_3 = $artistId
                                ");

        return $tracksNumber[0]->tracks_number;
    }

    public static function getArtistById($artistId)
    {
        $artist = DB::select("SELECT * FROM artists WHERE id = " . $artistId);
        return $artist[0];
    }

    public static function getArtistOwnerIdByArtistId(int $artistId): int
    {
        $ownerId = DB::table('artists')
            ->select('user_id_fk')
            ->where('id', '=', $artistId)
            ->limit(1)
            ->get();

        if (empty($ownerId[0])) {
            return 0;
        } else {
            $ownerId = $ownerId[0]->user_id_fk;
            return $ownerId;
        }
    }

    public function index($username)
    {
        $title = "Исполнители";

        $userId = UserController::getUserIdByUsername($username);
        $artists = $this->getArtistsByUserId($userId);
        $trArray = [];
        foreach($artists as $artist)
        {
            $artistId = $artist->id;
            if (!empty($artist->artist_ru))
            {
                $artist = $artist->artist_ru;
            }
            else continue;

            $artistToLower = strtolower($artist);
            $tr = "<tr><td><a href='artists/" . $artistId . "/" . str_replace(' ', '_', str_replace("'", "", $artistToLower)) . "'>";
            $tr .= "<span class='song-name'>";
            $tr .= $artist;
            $tr .= "</span></a></td></tr>";

            $trArray [] = $tr;
        }

        return view('artists.index', [
            'title' => $title,
            'trArray' => $trArray
        ]);
    }

    public function showArtistSongs($username, $artistId, $artist)
    {
        $title = $artist;
        $title = str_replace('_', ' ', $title);
        $title = ucwords($title);
        $artistTracks = $this->getArtistTracksById($artistId);

        $trArray = [];
        foreach($artistTracks as $artistTrack)
        {
            $trackId = $artistTrack->id;
            $track_name_en = $artistTrack->track_name_en;
            $track_name_en = strtolower($track_name_en);

            $tr = "<tr><td><a href='/user/{$username}/tracks/" . $trackId . "/" . str_replace(' ', '_', str_replace("'", "", $track_name_en)) . "'>";
            $tr .= "<span class='song-name'>";
            if ($artistTrack->track_name_ru)
            {
                $tr .= $artistTrack->track_name_ru;
            }
            else
            {
                $tr .= $artistTrack->track_name_en;
            }
            $tr .= "</span> - <span class='song-artist'>";

            if ($artistTrack->artist_1 != NULL)
            {
                $artist1 = $this->getArtistById($artistTrack->artist_1);
            }
            if ($artistTrack->artist_2 != NULL)
            {
                $artist2 = $this->getArtistById($artistTrack->artist_2);
            }
            else $artist2 = NULL;
            if ($artistTrack->artist_3 != NULL)
            {
                $artist3 = $this->getArtistById($artistTrack->artist_3);
            }
            else $artist3 = NULL;

            if (!empty($artist1->artist_ru))
            {
                $tr .= $artist1->artist_ru;
            }
            else
            {
                $tr .= $artist1->artist_en;
            }
            if (!empty($artist2->artist_ru))
            {
                $tr .= ', ' . $artist2->artist_ru;
            }
            else if (!empty($artist2->artist_en))
            {
                $tr .= ', ' . $artist2->artist_en;
            }
            if (!empty($artist3->artist_ru))
            {
                $tr .= ', ' . $artist3->artist_ru;
            }
            else if (!empty($artist3->artist_en))
            {
                $tr .= ', ' . $artist3->artist_en;
            }
            $tr .= "</span></a></td></tr>";
            $trArray [] = $tr;
        }

        return view('artists.showArtistSongs', [
            'title' => $title,
            'trArray' => $trArray,
        ]);
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

        $title = "Добавить исполнителя";

        if ($request->isMethod('get')) {
            $msg = '';
            $msgClass = '';

            return view('artists.add', [
                'title' => $title,
                'msg' => $msg,
                'msgClass' => $msgClass
            ]);
        } elseif ($request->isMethod('post')) {
            $this->validate($request, [
                'artist_en' => 'required',
                'userIdFromForm' => 'required',
            ]);

            # Проверяем, не пусто ли необходимое поле.
            if (!empty($request['artist_en']) and !empty($request['userIdFromForm'])) {
                # Если пользователь, отправивший форму, не совпадает с текущим авторизованным пользователем, прерываем выполнение.
                if ($currentUserId != $request['userIdFromForm']) {
                    $msg = 'Вы зашли под другим пользователем.';
                    $msgClass = 'alert-danger';
                    return view('artists.add', [
                        'title' => $title,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }

                $artist_en = $request['artist_en'];
                if (!empty($request['artist_ru'])) {
                    $artist_ru = $request['artist_ru'];
                } else {
                    $artist_ru = $request['artist_en'];
                }

                # Смотрим, есть ли автор, которого пытаемся добавить, в таблице artists.
                $noMatches = true;
                $artists = $this->getArtistsByUserId($currentUserId);
                foreach($artists as $artist) {
                    if (strtoupper($artist_ru) == strtoupper($artist->artist_ru) or strtoupper($artist_ru) == strtoupper($artist->artist_en)) {
                        $noMatches = false;
                    } elseif (strtoupper($artist_en) == strtoupper($artist->artist_ru) or strtoupper($artist_en) == strtoupper($artist->artist_en)) {
                        $noMatches = false;
                    } else {
                        continue;
                    }
                }

                if ($noMatches) {
                    $inserted = DB::table('artists')->insert(
                        [
                            'artist_en' => $artist_en,
                            'artist_ru' => $artist_ru,
                            'user_id_fk' => $currentUserId,
                        ]
                    );

                    if ($inserted) {
                        $msg = 'Исполнитель добавлен.';
                        $msgClass = 'alert-success';
                    }
                    else {
                        $msg = 'Ошибка при добавлении исполнителя.';
                        $msgClass = 'alert-danger';
                    }

                    return view('artists.add', [
                        'title' => $title,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                } else {
                    $msg = 'Такой исполнитель уже есть в базе';
                    $msgClass = 'alert-danger';

                    return view('artists.add', [
                        'title' => $title,
                        'msg' => $msg,
                        'msgClass' => $msgClass
                    ]);
                }
            }
        }
    }

    public function edit(Request $request)
    {
        date_default_timezone_set("Europe/Moscow");

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

        $title = "Выбор исполнителя для изменения";

        if ($request->isMethod('get')) {
            $msg = '';
            $msgClass = '';

            return view('artists.edit', [
                'title' => $title,
                'artists' => $this->getArtistsByUserId($currentUserId),
                'msg' => $msg,
                'msgClass' => $msgClass,
            ]);
        }
        elseif ($request->isMethod('patch')) {
            $this->validate($request, [
                'artist' => 'required',
                'artistEditedEn' => 'required',
                'artistEditedRu' => 'required',
                'userIdFromForm' => 'required',
            ]);

            if (!empty($request['artist']) and !empty($request['artistEditedEn']) and !empty($request['artistEditedRu']) and !empty($request['userIdFromForm'])) {
                $artistOldId = $request['artist'];
                $artistEditedEn = $request['artistEditedEn'];
                $artistEditedRu = $request['artistEditedRu'];
                $userIdFromForm = $request['userIdFromForm'];

                # Если пользователь, отправивший форму, не совпадает с текущим авторизованным пользователем, прерываем выполнение.
                if ($currentUserId != $request['userIdFromForm']) {
                    return view('artists.edit', [
                        'title' => $title,
                        'artists' => $this->getArtistsByUserId($currentUserId),
                        'msg' => 'Вы зашли под другим пользователем.',
                        'msgClass' => 'alert-danger',
                    ]);
                }

                # Если пользователь, отправивший форму, не является владельцем исполнителя, прерываем выполнение.
                if ($request['userIdFromForm'] != $this->getArtistOwnerIdByArtistId((int) $artistOldId)) {
                    return view('artists.edit', [
                        'title' => $title,
                        'artists' => $this->getArtistsByUserId($currentUserId),
                        'msg' => 'Вы не владелец этого исполнителя.',
                        'msgClass' => 'alert-danger',
                    ]);
                }


                $noChanges = true;

                $artistOld = $this->getArtistById($artistOldId);
                if ( ($artistEditedEn != $artistOld->artist_en) or ($artistEditedRu != $artistOld->artist_ru) ) {
                    $noChanges = false;
                }

                if ($noChanges) {
                    return view('artists.edit', [
                        'title' => $title,
                        'artists' => $this->getArtistsByUserId($currentUserId),
                        'msg' => 'Нет изменений ни в англ., ни в рус.',
                        'msgClass' => 'alert-danger',
                    ]);
                }
                elseif ($noChanges == false) {
                    $affectedArtistTable = DB::update
                    ("
                        UPDATE ARTISTS
                        SET
                        artist_en = ?,
                        artist_ru = ?,
                        updated_at = '" . date('Y-m-d H:i:s') . "',
                        user_id_fk = ?
                        WHERE
                        id = ?
                        ",
                        [$artistEditedEn, $artistEditedRu, $userIdFromForm, $artistOldId]
                    );

                    $msg = 'Исполнитель изменён. ';
                    $msg .= "Строк затронуто: $affectedArtistTable";

                    return view('artists.edit', [
                        'title' => $title,
                        'artists' => $this->getArtistsByUserId($currentUserId),
                        'msg' => $msg,
                        'msgClass' => 'alert-success',
                    ]);
                }
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

        $title = "Удалить исполнителя";

        if ($request->isMethod('get')) {
            return view('artists.delete', [
                'title' => $title,
                'artists' => $this->getArtistsByUserId($currentUserId),
                'msg' => '',
                'msgClass' => '',
            ]);
        }
        elseif ($request->isMethod('delete')) {
            $this->validate($request, [
                'artist_id' => 'required',
                'userIdFromForm' => 'required',
            ]);

            if (!empty($request['artist_id']) and !empty($request['userIdFromForm'])) {
                # Если пользователь, отправивший форму, не совпадает с текущим авторизованным пользователем, прерываем выполнение.
                if ($currentUserId != $request['userIdFromForm']) {
                    return view('artists.delete', [
                        'title' => $title,
                        'artists' => $this->getArtistsByUserId($currentUserId),
                        'msg' => 'Вы зашли под другим пользователем.',
                        'msgClass' => 'alert-danger',
                    ]);
                }

                # Если пользователь, отправивший форму, не является владельцем исполнителя, прерываем выполнение.
                if ($request['userIdFromForm'] != $this->getArtistOwnerIdByArtistId((int) $request['artist_id'])) {
                    return view('artists.delete', [
                        'title' => $title,
                        'artists' => $this->getArtistsByUserId($currentUserId),
                        'msg' => 'Вы не владелец этого исполнителя или исполнитель отсутствует.',
                        'msgClass' => 'alert-danger',
                    ]);
                }

                # Смотрим, есть ли автор, которого пытаемся удалить, в таблице artists.
                $artistExists = false;
                $artists = $this->getArtistsByUserId($currentUserId);
                foreach($artists as $artist) {
                    if ($request['artist_id'] == $artist->id) $artistExists = true;
                    else continue;
                }

                # Получаем количество песен исполнителя.
                # Нужно, чтобы у исполнитя, которого удаляем, не было песен.
                $artistHasTracks = false;
                $artistTracksNumber = $this->getArtistTracksNumberById($request['artist_id']);
                if ($artistTracksNumber >= 1) {
                    $artistHasTracks = true;
                }

                if ($artistExists) {
                    if ($artistHasTracks) {
                        return view('artists.delete', [
                            'title' => $title,
                            'artists' => $this->getArtistsByUserId($currentUserId),
                            'msg' => 'У выбранного исполнителя есть треки. Сначала удалите треки, потом исполнителя.',
                            'msgClass' => 'alert-danger',
                        ]);
                    } else {
                        # Возвращает количество затронутых строк.
                        $deleted = DB::delete('DELETE FROM artists WHERE id = :id', ['id' => $request['artist_id']]);

                        if($deleted >= 1) {
                            return view('artists.delete', [
                                'title' => $title,
                                'artists' =>$this->getArtistsByUserId($currentUserId),
                                'msg' => 'Запись удалена.',
                                'msgClass' => 'alert-success',
                            ]);
                        } else {
                            return view('artists.delete', [
                                'title' => $title,
                                'artists' =>$this->getArtistsByUserId($currentUserId),
                                'msg' => "Не удалось удалить исполнителя. Количество затронутых строк: $deleted",
                                'msgClass' => 'alert-danger',
                            ]);
                        }
                    }
                } else {
                    return view('artists.delete', [
                        'title' => $title,
                        'artists' =>$this->getArtistsByUserId($currentUserId),
                        'msg' => 'Такого исполнителя нет в базе',
                        'msgClass' => 'alert-danger',
                    ]);
                }
            }
        }
    }
}
