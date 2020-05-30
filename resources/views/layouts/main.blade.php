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
@yield('bottomScripts')
