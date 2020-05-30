<header>
    <div class="header-main-menu">
        <a href="{{ url('/') }}"><span class="header-main-title">Главная страница</span></a>
        <a href="{{ url('/artists') }}"><span class="header-main-menu-tabs">Исполнители</span></a>
        <a href="{{ url('/edit') }}"><span class="header-main-menu-tabs">Редактировать</span></a>
    </div>
</header>

<div id="menu-dropdown-id" class="menu-dropdown">
    <a href="{{ url('/') }}"><span class="header-main-title-media">Главная страница</span></a>
    <button class="dropdown-button" id="dropdown-button-id" onclick="dropdownController(); changeIcon()"></button>
    <span class="dropdown-content" id="myDropdown">
        <a href="{{ url('/artists') }}">Исполнители</a>
        <a href="{{ url('/edit') }}">Редактировать</a>
    </span>
</div>
