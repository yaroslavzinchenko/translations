@php
    /*session_unset();
    session_destroy();*/

        if (!empty($_SESSION['email']) and isset($_SESSION['email']) and !empty($_SESSION['is_verified']) and isset($_SESSION['is_verified'])) {
            if ($_SESSION['is_verified'] === 0) {
                $_SESSION['warning'] = "Email is not verified yet.";
                header('Location: /verify-email');
                exit();
            }
        }

        # Если пользователь запросил сброс пароля.
        /*if ($_SESSION['resetting_password'] === 1) {
            $_SESSION['warning'] = ".";
            header('Location: /reset-password');
            exit();
        }*/
@endphp

<!DOCTYPE html>
<html>

@include('includes.head')

<body>

<button onclick="jumpToTop()" id="toTopButton"></button>

@include('includes.header')

<main>
    @yield('content')
</main>

<footer style="text-decoration: none;">
    <p id ="PFooterElement"> / <a href="{{ url('/') }}">Начальная страница</a></p>
</footer>

<script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"></script>
<script src="{{asset('js/menuController.js')}}"></script>
<script src="{{asset('js/jumpToTopController.js')}}"></script>

</body>
</html>

<script src="{{asset('js/editFooter.js')}}"></script>
@yield('bottomScripts')
