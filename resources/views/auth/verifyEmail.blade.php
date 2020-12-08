@php

if (empty($_SESSION['email']) === true)
{
    # Если почта сессии пуста, перенаправляем залогиниться.
    $_SESSION['error'] = "Please login first.";
    header('Location: /login');
    exit();
}
if (!empty($_SESSION['is_verified']))
{
    # Если пользователь уже верифицирован, перенаправляем на главную страницу.
    if ($_SESSION['is_verified'] == 1)
    {
        header('Location: /');
        exit();
    }
}

@endphp



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Verify email</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form">
            <form action="/verify-email" method="POST" autocomplete="off">
                @csrf
                <h2 class="text-center">Code Verification</h2>

                @include('includes.checkForErrors')

                <div class="form-group">
                    <input class="form-control" type="number" name="verificationCode" placeholder="Enter verification code"
                           minlength="6" maxlength="6" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control button" type="submit" name="verifyEmail" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
