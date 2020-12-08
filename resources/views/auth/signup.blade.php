<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/auth.css')}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form">
            <form action="/signup" method="POST" autocomplete="off">
                @csrf
                <h2 class="text-center">Signup Form</h2>
                <p class="text-center">It's quick and easy.</p>

                @include('includes.checkForErrors')

                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Email Address"
                           maxlength="255" required
                           value="@php echo isset($_POST['email']) ? $_POST['email'] : ""; @endphp">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="username" placeholder="Username"
                           minlength="6" maxlength="255" required pattern="^[0-9a-zA-Z]+$"
                           value="@php echo isset($_POST['username']) ? $_POST['username'] : ""; @endphp">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password (min - 6)"
                           minlength="6" maxlength="255" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="check-password" placeholder="Confirm password"
                           minlength="6" maxlength="255" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <input class="form-control button" type="submit" name="signup" value="Signup">
                </div>
                <div class="link login-link text-center">Already a member? <a href="/login">Login here</a></div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
