<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

if (session_status() != PHP_SESSION_DISABLED and session_status() == PHP_SESSION_NONE) {
    session_start();
}

class AuthController extends Controller
{
    public static function checkIfUserLoggedIn(): int
    {
        if (!empty($_SESSION['email']) and isset($_SESSION['email'])) {
            return 1;
        }
        return 0;
    }

    public static function checkIfUserVerified(): int
    {
        if (!empty($_SESSION['is_verified']) and isset($_SESSION['is_verified'])) {
            if ($_SESSION['is_verified'] === 1) {
                return 1;
            }
            return 0;
        }
    }

    public function login(Request $request)
    {
        if (isset($_SESSION['email']) and !empty($_SESSION['email'])) {
            header('Location: /');
            exit();
        }

        if ($request->isMethod('get')) {
            return view('auth.login', [
                ]
            );
        }
        if ($request->isMethod('post')) {
            $errors = array();

            $validatedData = $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);

            $user = DB::table('users')
                ->select('id', 'email', 'username', 'password', 'is_verified')
                ->where('email', strtoupper($validatedData['email']))
                ->limit(1)
                ->get();
            if (count($user) > 0) {
                if (password_verify($validatedData['password'], $user[0]->password)) {
                    session_unset();
                    session_destroy();
                    session_start();
                    $_SESSION['userId'] = $user[0]->id;
                    $_SESSION['email'] = $user[0]->email;
                    $_SESSION['username'] = $user[0]->username;
                    $_SESSION['is_verified'] = $user[0]->is_verified;

                    if ($user[0]->is_verified === 1) {
                        header('Location: /');
                        exit();

                        /*return view('welcome.index', [
                                'title' => 'Добро пожаловать',
                                'errors' => $errors,
                            ]
                        );*/
                    }
                    else {
                        $_SESSION['warning'] = "Email is not verified yet.";
                        header('Location: /verify-email');
                        exit();
                    }

                }
                else {
                    $errors['incorrectEmailOrPassword'] = "Incorrect email or password.";
                    return view('auth.login', [
                            'errors' => $errors,
                        ]
                    );
                }
            }
            else {
                $errors['userMissing'] = "You are not a member yet. Please sign up.";
                return view('auth.login', [
                        'errors' => $errors,
                    ]
                );
            }
        }
    }

    public function logout(Request $request)
    {
        session_unset();
        session_destroy();
        session_start();
        header('location: /');
        exit();
    }

    public function signup(Request $request)
    {
        date_default_timezone_set("Europe/Moscow");

        if (isset($_SESSION['email']) and !empty($_SESSION['email'])) {
            header('Location: /');
            exit();
        }

        if ($request->isMethod('get')) {
            return view('auth.signup', [
                ]
            );
        }
        if ($request->isMethod('post')) {
            $errors = array();
            $validatedData = $this->validate($request, [
                'email' => 'required',
                'username' => 'required',
                'password' => 'required',
                'check-password' => 'required',
            ]);

            # Проверяем пароли.
            if ($validatedData['password'] !== $validatedData['check-password']) {
                $errors['password'] = "Passwords do not match.";
            }

            # Проверяем, существует ли уже пользователь с указанной почтой.
            $userEmail = DB::table('users')->where('email', $validatedData['email'])->limit(1)->get();
            if (count($userEmail) > 0) {
                $errors['email'] = "Email that you have entered already exists.";
            }

            # Проверяем, существует ли уже пользователь с указанным именем.
            $userName = DB::table('users')->where('username', $validatedData['username'])->limit(1)->get();
            if (count($userName) > 0) {
                $errors['username'] = "User with this name already exists.";
            }


            if (count($errors) === 0) {
                $encryptedPassword = password_hash($validatedData['password'], PASSWORD_DEFAULT);
                $verification_code = random_int(111111, 999999);

                try {
                    DB::beginTransaction();
                    $insertUser = DB::table('users')->insert(
                        [
                            'email' => strtoupper($validatedData['email']),
                            'username' => strtoupper($validatedData['username']),
                            'password' => $encryptedPassword,
                            'verification_code' => $verification_code,
                            'verification_code_sent_at' => date('Y-m-d H:i:s'),
                        ]
                    );

                    if ($insertUser) {
                        $subject = "Email Verification Code";
                        $message = "Your verification code is $verification_code";

                        if (mail($validatedData['email'], $subject, $message)) {
                            DB::commit();

                            /*session_unset();
                            session_destroy();*/

                            $userId = UserController::getUserIdByUsername(strtoupper($validatedData['username']));

                            if (session_status() != PHP_SESSION_DISABLED and session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                            else {
                                session_unset();
                                session_destroy();
                                session_start();
                            }
                            $_SESSION['info'] = "We've sent a verification code to your email. The code will expire in 1 hour.
                                                If you don't verify email in 1 hour, you will have to register again.";
                            $_SESSION['userId'] = $userId;
                            $_SESSION['email'] = $validatedData['email'];
                            $_SESSION['username'] = $validatedData['username'];
                            $_SESSION['is_verified'] = 0;


                            # Вроде как не нужно + зачем хранить пароль в сессии.
//                            $_SESSION['password'] = $validatedData['password'];
                            header('location: /verify-email');
                            exit();
                        }
                        else {
                            DB::rollback();
                            $errors['verifyEmail'] = "Failed to send code to the user's email.";
                            return view('auth.signup', [
                                    'errors' => $errors,
                                ]
                            );
                        }
                    }
                }
                catch (\Illuminate\Database\QueryException $ex) {
                    DB::rollback();
                    $errors['insertUser'] = "Failed to add user.";
                    return view('auth.signup', [
                            'errors' => $errors,
                        ]
                    );
                }
                catch (\Throwable $e) {
                    DB::rollback();
                    $error['rollback'] = "Rolled back.";
                }
            }
            else {
                return view('auth.signup', [
                        'errors' => $errors,
                    ]
                );
            }
        }
    }

    public function verifyEmail(Request $request)
    {
        date_default_timezone_set("Europe/Moscow");

        if ($request->isMethod('get')) {
            $errors = array();
            return view('auth.verifyEmail', [
                    'errors' => $errors,
                ]
            );
        }
        if ($request->isMethod('post')) {
            $errors = array();
            $validatedData = $this->validate($request, [
                'verificationCode' => 'required',
            ]);

            if (isset($validatedData['verificationCode'])) {
                $_SESSION['info'] = "";

                # Проверяем, существует ли уже пользователь с указанным кодом и почтой, которая сейчас в сессии.
                $userEmail = DB::table('users')
                    ->select('email')
                    ->where('email', $_SESSION['email'])
                    ->where('is_verified', 0)
                    ->where('verification_code', '!=', 0)
                    ->where('verification_code', $validatedData['verificationCode'])
                    ->limit(1)
                    ->get();
                if (count($userEmail) > 0) {
                    if ($userEmail[0]->email === strtoupper($_SESSION['email'])) {
                        $updated = DB::table('users')
                            ->where('email', strtoupper($userEmail[0]->email))
                            ->where('is_verified', 0)
                            ->update([
                                # updated_at можно убрать, потому что повесил триггер.
                                # Однако лучше оставить, чтобы можно было выбирать строки, у которых updated_at = email_verified_at.
                                # Триггер вызывается до обновления, поэтому если оставить только триггер,
                                # может быть несоответствие между updated_at и email_verified_at.
                                # Поэтому триггер оставляем для всех обновлений, но здесь всё равно явно обновляем поле.
                                'updated_at' => date('Y-m-d H:i:s'),
                                'verification_code' => 0,
                                'is_verified' => 1,
                                'email_verified_at' => date('Y-m-d H:i:s'),
                            ]);
                        if ($updated) {
                            $_SESSION['info'] = "Email has been verified.";
                            $_SESSION['is_verified'] = 1;
                            header('location: /login');
                            exit();
                        }
                        else {
                            $errors['verifyEmail'] = "Failed to update.";
                        }
                    }
                    else {
                        $errors['emailsNoMatch'] = "Session email and email from database do not match.";
                    }
                }
                else {
                    $errors['incorrectCode'] = "Incorrect code.";
                    return view('auth.verifyEmail', [
                            'errors' => $errors,
                        ]
                    );
                }
            }
        }


    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('get')) {

            return view('auth.forgotPassword', [
                ]
            );
        }

        if ($request->isMethod('post')) {

        }
    }
}
