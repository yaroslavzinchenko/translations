@extends('layouts.main')

@section('content')
    <section class="translations-section">

        <header class="translations-header">
            <h1 class="translations-header-h1">{{$title}}</h1>
        </header>

        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Добавить</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <a href="/tracks/add">
                        <span class="song-name">Добавить трек</span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="/artists/add">
                        <span class="song-name">Добавить исполнителя</span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Обновить</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <a href="/tracks/update">
                        <span class="song-name">Редактировать трек</span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="/artists/update">
                        <span class="song-name">Редактировать исполнителя</span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <a href="/tracks/delete">
                        <span class="song-name">Удалить трек</span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="/artists/delete">
                        <span class="song-name">Удалить исполнителя</span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

    </section>
@endsection
