<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form">
            <form action="/forgot-password" method="POST">
                @csrf
                <h2 class="text-center">Forgot Password</h2>
                <p class="text-center">Enter your email address</p>

                @include('includes.checkForErrors')

                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Enter email address" required>
                </div>
                <div class="form-group">
                    <input class="form-control button" type="submit" name="check-email" value="Continue">
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
