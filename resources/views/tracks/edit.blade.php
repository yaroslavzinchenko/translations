@extends('layouts.main')

@section('content')
    @if (!empty($_SESSION['error']) and isset($_SESSION['error']))
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <br>
        <div class="container">
            <div class="alert alert-danger">{{$_SESSION['error']}}</div>
        </div>
    @endif
    @php
        $_SESSION['error'] = '';
    @endphp

    <section class="translations-section">

        <header class="translations-header">
            <h1 class="translations-header-h1">{{$title}}</h1>
        </header>

        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Треки</th>
            </tr>
            </thead>
            <tbody>

            @foreach($trArray as $tr)
                {!! $tr !!}
            @endforeach

            </tbody>
        </table>

    </section>
@endsection
