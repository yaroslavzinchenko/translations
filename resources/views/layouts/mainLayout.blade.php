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
    <title>Переводы и тексты</title>

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

{{--<main>
    <section class="translations-section">

        <header class="translations-header">
            <h1 class="translations-header-h1">Переводы и тексты</h1>
        </header>

        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Треки</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $query = "SELECT DISTINCT track_name,
										track_name_ru,
										artist_1,
										artist_1_ru,
										artist_2,
										artist_2_ru,
										artist_3,
										artist_3_ru
										FROM tracks ORDER BY track_name_ru";
            if ($result = $connection->query($query))
            {
                while ($row = $result->fetch_assoc())
                {
                    $track_name = $row['track_name'];
                    $artist_1 = $row['artist_1'];

                    if ($track_name == 'Where the Streets Have No Name' && $artist_1 = 'U2')
                    {
                        $tr = "<tr>
						<td><a href='tracks/where_the_streets_have_no_name.php'><img src='/translations/assets/images/icons/baseline-translate-24px.svg' alt='' class='song-with-trans'><span class='song-name'>Where the Streets Have No Name</span> - <span class='song-artist'>U2</a></td>
					</tr>";
                        echo $tr;
                        continue;
                    }

                    $track_name = strtolower($track_name);

                    $tr = "<tr><td><a href='tracks/" . str_replace(' ', '_', str_replace("'", "", $track_name)) . ".php'>";

                    $tr .= "<span class='song-name'>";

                    if ($row['track_name_ru'])
                    {
                        $tr .= $row['track_name_ru'];
                    }
                    else
                    {
                        $tr .= $row['track_name'];
                    }

                    $tr .= "</span> - <span class='song-artist'>";

                    if ($row['artist_1_ru'])
                    {
                        $tr .= $row['artist_1_ru'];
                    }
                    else
                    {
                        $tr .= $row['artist_1'];
                    }
                    if ($row['artist_2_ru'] and $row['artist_2_ru'] !== null)
                    {
                        $tr .= ', ' . $row['artist_2_ru'];
                    }
                    else if ($row['artist_2'] and $row['artist_2'] !== null)
                    {
                        $tr .= ', ' . $row['artist_2'];
                    }
                    if ($row['artist_3_ru'] and $row['artist_3_ru'] !== null)
                    {
                        $tr .= ', ' . $row['artist_3_ru'];
                    }
                    else if ($row['artist_3'] and $row['artist_3'] !== null)
                    {
                        $tr .= ', ' . $row['artist_3'];
                    }

                    $tr .= "</span></a></td></tr>";

                    echo $tr;

                    /*echo $row['track_name'];
                    echo $row['artist_1'];
                    echo '<br>';*/
                }

                $result->free();
            }

            $connection->close();
            ?>

            </tbody>
        </table>

        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Игры</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><a href="games/doom/doom.php">DOOM</a></td>
            </tr>
            </tbody>
        </table>

    </section>
</main>--}}

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
