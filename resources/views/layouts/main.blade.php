<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <!-- Масштабирование на мобильных устройствах -->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <!-- Цвет самой верхней панели за пределами браузера на мобильных устройствах (точно работает в Google Chrome для Android) -->
    <meta name="theme-color" content="#EEEEEE">

    <!-- Ссылка на CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <link rel="icon" sizes="192x192" href="{{asset('images/icons/high-res.png')}}">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=cyrillic" rel="stylesheet">

    <!-- Page title -->
    <title>{{$title}}</title>

</head>

<body>

<button onclick="jumpToTop()" id="toTopButton"></button>

<header>
    <div class="header-main-menu">
        <a href="{{ url('/') }}"><span class="header-main-title">Главная страница</span></a>
        <a href="{{ url('/artists') }}"><span class="header-main-menu-tabs">Исполнители</span></a>
        <a href="{{ url('/tracks/add') }}"><span class="header-main-menu-tabs">Добавить трек</span></a>
    </div>
</header>

<div id="menu-dropdown-id" class="menu-dropdown">
    <a href="{{ url('/') }}"><span class="header-main-title-media">Главная страница</span></a>
    <button class="dropdown-button" id="dropdown-button-id" onclick="dropdownController(); changeIcon()"></button>
    <span class="dropdown-content" id="myDropdown">
        <a href="{{ url('/artists') }}">Исполнители</a>
        <a href="{{ url('/tracks/add') }}">Добавить трек</a>
    </span>
</div>

<main>
    @yield('content')
</main>

<footer>
    <p id ="PFooterElement"> / <a href="{{ url('/') }}">Главная страница</a></p>
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
