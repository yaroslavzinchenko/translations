@extends('layouts.main')


<body>

<button onclick="jumpToTop()" id="toTopButton"></button>

<?php include('includes/main_menu.php') ?>
@include

<main>
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
            require('config/index.php');
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
</main>

<footer>
    <p id ="PFooterElement"> / <a href="/translations/">Главная страница</a></p>
</footer>

<script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous"></script>
<script src="/translations/assets/js/menuController.js"></script>
<script src="/translations/assets/js/jumpToTopController.js"></script>

</body>
</html>

<script src="/translations/assets/js/editFooter.js"></script>
