@extends('layouts.main')

@section('content')
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
