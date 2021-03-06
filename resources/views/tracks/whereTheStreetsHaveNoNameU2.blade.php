@extends('layouts.main')

@section('content')
    <section class="translations-section">

        <header class="translations-header">
            <h1 class="translations-header-h1">U2 - Where the Streets Have No Name</h1>
        </header>

        <div class="switch-text">
            <label class="switch">
                <input type="checkbox" onclick="textController()">
                <span class="slider round"></span>
            </label>Текст с переводом / Только текст
        </div>

        <div id="textWithTranslation">
            <div class="card-lyrics card-shadow">
                <p>
                <div class="string-container">
                    <div class="string-original">I wanna run, I want to hide</div>
                    <div class="string-translation">Я хочу убежать, я хочу спрятаться,</div>
                </div>
                <div class="string-container">
                    <div class="string-original">I wanna tear down the walls</div>
                    <div class="string-translation">Я хочу снести стены,</div>
                </div>
                <div class="string-container">
                    <div class="string-original">That hold me inside.</div>
                    <div class="string-translation">Что держат меня внутри.</div>
                </div>
                <div class="string-container">
                    <div class="string-original">I wanna reach out</div>
                    <div class="string-translation">Я хочу протянуться</div>
                </div>
                <div class="string-container">
                    <div class="string-original">And touch the flame</div>
                    <div class="string-translation">И дотронуться до пламени</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Where the streets have no name.</div>
                    <div class="string-translation">Где у улиц нет имен.</div>
                </div>
                </p>

                <p class="verse">
                <div class="string-container">
                    <div class="string-original">I wanna feel sunlight on my face.</div>
                    <div class="string-translation">Я хочу ощутить свет солнца на своем лице.</div>
                </div>
                <div class="string-container">
                    <div class="string-original">I see the dust-cloud</div>
                    <div class="string-translation">Я вижу, как облако пыли</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Disappear without a trace.</div>
                    <div class="string-translation">Исчезает без следа.</div>
                </div>
                <div class="string-container">
                    <div class="string-original">I wanna take shelter</div>
                    <div class="string-translation">Я хочу укрыться</div>
                </div>
                <div class="string-container">
                    <div class="string-original">From the poison rain</div>
                    <div class="string-translation">От ядовитого дождя</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Where the streets have no name</div>
                    <div class="string-translation">Где у улиц нет имен</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Where the streets have no name</div>
                    <div class="string-translation">Где у улиц нет имен</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Where the streets have no name.</div>
                    <div class="string-translation">Где у улиц нет имен.</div>
                </div>
                </p>

                <p class="verse">
                <div class="string-container">
                    <div class="string-original">We're still building and burning down love</div>
                    <div class="string-translation">Мы все еще строим и сжигаем любовь</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Burning down love.</div>
                    <div class="string-translation">Сжигаем любовь.</div>
                </div>
                <div class="string-container">
                    <div class="string-original">And when I go there</div>
                    <div class="string-translation">И когда я отправлюсь туда,</div>
                </div>
                <div class="string-container">
                    <div class="string-original">I go there with you</div>
                    <div class="string-translation">Я пойду туда с тобой</div>
                </div>
                <div class="string-container">
                    <div class="string-original">(It's all I can do).</div>
                    <div class="string-translation">(Это все, что я могу сделать).</div>
                </div>
                </p>

                <p class="verse">
                <div class="string-container">
                    <div class="string-original">The city's a flood, and our love turns to rust.</div>
                    <div class="string-translation">Город затоплен, и наша любовь ржавеет.</div>
                </div>
                <div class="string-container">
                    <div class="string-original">We're beaten and blown by the wind</div>
                    <div class="string-translation">Мы разбиты и унесены ветром</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Trampled in dust.</div>
                    <div class="string-translation">Растоптаны в пыль.</div>
                </div>
                <div class="string-container">
                    <div class="string-original">I'll show you a place</div>
                    <div class="string-translation">Я покажу тебе место</div>
                </div>
                <div class="string-container">
                    <div class="string-original">High on a desert plain</div>
                    <div class="string-translation">Высоко на пустынной равнине</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Where the streets have no name</div>
                    <div class="string-translation">Где у улиц нет имен</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Where the streets have no name</div>
                    <div class="string-translation">Где у улиц нет имен</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Where the streets have no name.</div>
                    <div class="string-translation">Где у улиц нет имен.</div>
                </div>
                </p>

                <p class="verse">
                <div class="string-container">
                    <div class="string-original">We're still building and burning down love</div>
                    <div class="string-translation">Мы все еще строим и сжигаем любовь</div>
                </div>
                <div class="string-container">
                    <div class="string-original">Burning down love.</div>
                    <div class="string-translation">Сжигаем любовь.</div>
                </div>
                <div class="string-container">
                    <div class="string-original">And when I go there</div>
                    <div class="string-translation">И когда я отправлюсь туда,</div>
                </div>
                <div class="string-container">
                    <div class="string-original">I go there with you</div>
                    <div class="string-translation">Я пойду туда с тобой</div>
                </div>
                <div class="string-container">
                    <div class="string-original">(It's all I can do).</div>
                    <div class="string-translation">(Это все, что я могу сделать).</div>
                </div>
                </p>
            </div>
        </div>

        <div id="textWithoutTranslation">
            <div class="card-lyrics card-shadow">
                <p>
                <div class="string-container">I wanna run, I want to hide</div>
                <div class="string-container">I wanna tear down the walls</div>
                <div class="string-container">That hold me inside.</div>
                <div class="string-container">I wanna reach out</div>
                <div class="string-container">And touch the flame</div>
                <div class="string-container">Where the streets have no name.</div>
                </p>

                <p class="verse">
                <div class="string-container">I wanna feel sunlight on my face.</div>
                <div class="string-container">I see the dust-cloud</div>
                <div class="string-container">Disappear without a trace.</div>
                <div class="string-container">I wanna take shelter</div>
                <div class="string-container">From the poison rain</div>
                <div class="string-container">Where the streets have no name</div>
                <div class="string-container">Where the streets have no name</div>
                <div class="string-container">Where the streets have no name.</div>
                </p>

                <p class="verse">
                <div class="string-container">We're still building and burning down love</div>
                <div class="string-container">Burning down love.</div>
                <div class="string-container">And when I go there</div>
                <div class="string-container">I go there with you</div>
                <div class="string-container">(It's all I can do).</div>
                </p>

                <p class="verse">
                <div class="string-container">The city's a flood, and our love turns to rust.</div>
                <div class="string-container">We're beaten and blown by the wind</div>
                <div class="string-container">Trampled in dust.</div>
                <div class="string-container">I'll show you a place</div>
                <div class="string-container">High on a desert plain</div>
                <div class="string-container">Where the streets have no name</div>
                <div class="string-container">Where the streets have no name</div>
                <div class="string-container">Where the streets have no name.</div>
                </p>

                <p class="verse">
                <div class="string-container">We're still building and burning down love</div>
                <div class="string-container">Burning down love.</div>
                <div class="string-container">And when I go there</div>
                <div class="string-container">I go there with you</div>
                <div class="string-container">(It's all I can do).</div>
                </p>
            </div>
        </div>

        <table class="card-translations-table-translation card-shadow">
            <thead>
            <tr>
                <th>Ссылки</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><a href="spotify:track:4qgZs0RNjdzKAS22lP0QjY">Spotify</a></td>
            </tr>
            <tr>
                <td><a href="https://youtu.be/f4zQWBBGUYI" target='_blank'>YouTube</a></td>
            </tr>
            </tbody>
        </table>

    </section>
    <script src="/js/textController.js"></script>
@endsection
