<header>
    <div class="header-main-menu">
        <a href="{{ url('/') }}"><span class="header-main-title">Начальная страница</span></a>
        <a href="{{ url('/tracks') }}"><span class="header-main-menu-tabs">Треки</span></a>
        <a href="{{ url('/artists') }}"><span class="header-main-menu-tabs">Исполнители</span></a>

        @if (!empty($_SESSION['email']) and isset($_SESSION['email']))
            @if ($_SESSION['is_verified'] === 1)
                <a href="{{ url('/edit') }}"><span class="header-main-menu-tabs">Редактировать</span></a>
            @endif
        @endif

        @if (isset($_SESSION['username']))
            <a href="{{ url('/logout') }}"><span class="header-main-menu-tabs">Выйти</span></a>
        @else <a href="{{ url('/login') }}"><span class="header-main-menu-tabs">Войти</span></a>
        @endif
    </div>
</header>

<div id="menu-dropdown-id" class="menu-dropdown">
    <a href="{{ url('/') }}"><span class="header-main-title-media">Начальная страница</span></a>
    {{--<a href="{{ url('/tracks') }}"><span class="header-main-title-media">Тексты</span></a>--}}
    <button class="dropdown-button" id="dropdown-button-id" onclick="dropdownController(); changeIcon()"></button>
    <span class="dropdown-content" id="myDropdown">
        <a href="{{ url('/tracks') }}">Треки</a>
        <a href="{{ url('/artists') }}">Исполнители</a>
        @if (!empty($_SESSION['email']) and isset($_SESSION['email']))
            @if ($_SESSION['is_verified'] === 1)
                <a href="{{ url('/edit') }}">Редактировать</a>
            @endif
        @endif

        @if (isset($_SESSION['username']))
        <a href="{{ url('/logout') }}">Выйти</a>
        @else <a href="{{ url('/login') }}">Войти</a>
        @endif

    </span>
</div>
