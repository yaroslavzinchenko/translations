@extends('layouts.mainLayout')

@section('content')
    <section class="translations-section">

        <header class="translations-header">
            <h1 class="translations-header-h1">{{$title}}</h1>
        </header>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Полная история Палача Рока</h2>
            <audio src="{{url('/audio/slayers_testaments/slayers_full_story.mp3')}}" controls preload="metadata"></audio>

        </div>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Завет Палача 1</h2>
            <audio src="{{url('/audio/slayers_testaments/slayers_testament_i.mp3')}}" controls preload="metadata"></audio>
            <h4>Оригинальный текст</h4>
            <p>
                In the first age, in the first battle, when the shadows first lengthened, one stood. Burned by the embers of Armageddon, his soul blistered by the fires of Hell and tainted beyond ascension, he chose the path of perpetual torment. In his ravenous hatred he found no peace; and with boiling blood he scoured the Umbral Plains seeking vengeance against the dark lords who had wronged him. He wore the crown of the Night Sentinels, and those that tasted the bite of his sword named him... the Doom Slayer.
            </p>
            <h4>Официальный перевод</h4>
            <p>
                В Первую эпоху, в первой битве, когда тени впервые стали длинными, выстоял один воин. Его опалили угли Армагеддона, душа его была обожжена пламенем ада, осквернена и не могла уже вознестись, так что он избрал путь вечного мучения. Ненависть его была так велика, что он не мог обрести покоя и скитался по равнине Умбрал, желая отомстить Темным Владыкам, причинившим ему столько зла. Он носил корону Ночных Стражей, и те, кто отведал его меча, нарекли его Палачом Рока.
            </p>
            <h4>Мой перевод</h4>
            <p>
                В первый век, в первом сражении, когда тени впервые удлинились, выстоял один воин. Сожженная углями Армагеддона, его душа покрылась волдырями от пламён Ада и заразилась за пределами вознесения, он избрал путь вечных мук. Он не нашел покоя в своей голодной ненависти; и с кипящей кровью он скитался по Умбральским Равнинам, пытаясь отомстить темным лордам, причинившим ему столько зла. Он носил корону Ночных Стражей, и те, кто отведал меча его, нарекли его... Палачом Рока.
            </p>
        </div>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Завет Палача 2</h2>
            <audio src="{{url('/audio/slayers_testaments/slayers_testament_ii.mp3')}}" controls preload="metadata"></audio>
            <h4>Оригинальный текст</h4>
            <p>
                Tempered by the fires of Hell, his iron will remained steadfast through the passage that preys upon the weak. For he alone was the Hell Walker, the Unchained Predator, who sought retribution in all quarters, dark and light, fire and ice, in the beginning and the end, and he hunted the slaves of Doom with barbarous cruelty; for he passed through the divide as none but demon had before.
            </p>
            <h4>Официальный перевод</h4>
            <p>
                Его стальная воля, закалённая адским пламенем, не дрогнет там, где слабые будут растерзаны. Ведь только он был Путником Ада, Неудержимым Хищником, ищущим воздаяния всюду: во тьме и при свете, в огне и пламени, в начале и в конце, и он преследовал рабов Рока с неимоверной жестокостью, ибо прошел через Раздел, где проходили прежде лишь демоны.
            </p>
            <h4>Мой перевод</h4>
            <p>
                В закаленной огнем Ада броне он пройдет через проход, где слабый будет растерзан. Ибо он один был Путником Ада, Неудержимым Хищником, ищущим возмездия везде: во тьме и при свете, в огне и во льду, в начале и в конце, и он охотился за рабами Рока с варварской жестокостью, ибо он прошел через раздел, где прежде проходил лишь демон.
            </p>
        </div>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Завет Палача 3</h2>
            <audio src="{{url('/audio/slayers_testaments/slayers_testament_iii.mp3')}}" controls preload="metadata"></audio>
            <h4>Оригинальный текст</h4>
            <p>
                And in his conquest against the blackened souls of the doomed, his prowess was shown. In his crusade, the seraphim bestowed upon him terrible power and speed, and with his might he crushed the obsidian pillars of the Blood Temples. He set forth without pity upon the beasts of the nine circles. Unbreakable, incorruptible, unyielding, the Doom Slayer sought to end the dominion of the dark realm.
            </p>
            <h4>Официальный перевод</h4>
            <p>
                И в битве с черными душами обреченных показал он свою доблесть. Для его крестового похода серафим даровал ему огромную силу и быстроту, и мощью своей сокрушил он обсидиановые колонны Храмов Крови. Не зная жалости, обрушился он на чудовищ из девяти кругов. Палач Рока — несокрушимый, неумолимый, несгибаемый — решил искоренить царство тьмы.
            </p>
            <h4>Мой перевод</h4>
            <p>
                И в покорении почерневших душ обреченных он показал свою доблесть. В его крестовом походе серафим даровал ему страшную силу и скорость, и со своей мощью он сокрушил обсидиановые столпы Храмов Крови. Без жалости он двинулся на чудовищ девяти кругов. Несокрушимый, неподкупный, несгибаемый, Палач Рока стремился положить конец владычеству царства тьмы.
            </p>
        </div>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Завет Палача 4</h2>
            <audio src="{{url('/audio/slayers_testaments/slayers_testament_iv.mp3')}}" controls preload="metadata"></audio>
            <h4>Оригинальный текст</h4>
            <p>
                The age of his reckoning was uncounted. The scribes carved his name deep in the tablets of Hell across eons, and each battle etched terror in the hearts of the demons. They knew he would come, as he always had, as he always will, to feast on the blood of the wicked. For he alone could draw strength from his fallen foes, and ever his power grew, swift and unrelenting.
            </p>
            <h4>Официальный перевод</h4>
            <p>
                Его отмщение заняло целую вечность. Эпоху за эпохой писцы вырезали имя его на скрижалях ада, и каждая битва вселяла ужас в сердца демонов. Они знали, что он придет — как приходил прежде, и всегда будет — и станет пировать на крови нечестивых. Ибо он мог черпать силу из павших врагов и росла его мощь, и не знал он усталости и покоя.
            </p>
            <h4>Мой перевод</h4>
            <p>
                Его отмщение заняло целую вечность. Эпоху за эпохой писцы вырезали его имя глубоко на скрижалях Ада, и каждая битва вселяла ужас в сердца демонов. Они знали, что он придет, как прежде приходил всегда, как всегда будет, и станет пировать на крови нечестивых. Ибо он один мог черпать силу из своих павших врагов, и росла его мощь, быстрая и безжалостная.
            </p>
        </div>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Завет Палача 5</h2>
            <audio src="{{url('/audio/slayers_testaments/slayers_testament_v.mp3')}}" controls preload="metadata"></audio>
            <h4>Оригинальный текст</h4>
            <p>
                None could stand before the horde but the Doom Slayer. Despair spread before him like a plague, striking fear into the shadow-dwellers, driving them to deeper and darker pits. But from the depths of the abyss rose The Great One, a champion mightier than all who had come before. The Titan, of immeasurable power and ferocity. He strode upon the plain and faced the Doom Slayer, and a mighty battle was fought on the desolate plains. The Titan fought with the fury of the countless that had fallen at the Doom Slayer's hand, but there fell the Titan, and in his defeat the shadow horde were routed.
            </p>
            <h4>Официальный перевод</h4>
            <p>
                Никто не мог устоять перед Ордой — лишь Палач Рока. Ужас перед ним распространялся подобно чуме, он вселял отчаяние в противников света, загоняя их все глубже в их темные норы. Но восстал из глубин бездны Великий — воитель, который был сильнее всех, что являлись прежде. То был Титан неизмеримой силы и ярости. Он прошел по опустелой равнине и встретился с Палачом Рока, и началась яростная битва. Титан вобрал в себя гнев бесчисленных жертв Палача Рока, но и он пал; и после его поражения темная Орда обратилась в бегство.
            </p>
        </div>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Завет Палача 6</h2>
            <audio src="{{url('audio/slayers_testaments/slayers_testament_vi.mp3')}}" controls preload="metadata"></audio>
            <h4>Оригинальный текст</h4>
            <p>
                And in his terrible rancor between worlds and through time, the Hell Walker found the wretch who shall not be named, but in his heresy was loyal to his evil cause. The wretch adorned the Doom Slayer in a mighty armor, wrought in the forges of Hell, impenetrable and unyielding. With sword and shield of adamantine strength, the Doom Slayer set to banishing all that were left unbroken by his savagery to the void.
            </p>
            <h4>Официальный перевод</h4>
            <p>
                Странствуя между мирами и эпохами, нашел Путник Ада жалкое создание, чье имя не следует называть. Нечестивое это создание обратилось на службу Путнику. Оно обрядило Палача Рока в прочные доспехи, выкованные в кузницах ада, неразрушимые и негнущиеся. С мечом и щитом невероятной силы начал Палач Рока истреблять все, что до сих пор избегало ярости его.
            </p>
        </div>

        <div class="card-doom-slayers-testament card-shadow">
            <h2 class="translations-header-h2">Завет Палача 7</h2>
            <audio src="{{url('audio/slayers_testaments/slayers_testament_vii.mp3')}}" controls preload="metadata"></audio>
            <h4>Оригинальный текст</h4>
            <p>
                Yet as the mighty Titan fell and dread engulfed the armies of Doom, the demon priests of the Blood Temples laid a trap to capture this scourge of Hell. Insatiable, even by the vanquishing of the Great One, the Hell Walker sought prey in the tombs of the Blood Keep. And blinded by his fervor, the lure drew him in. The priests brought down the temple upon the Doom Slayer, and in his defeat entombed him in the cursed sarcophagus. The mark of the Doom Slayer was burned upon his crypt, a warning to all of Hell that the terror within must never be freed. There he lies still, and ever more, in silent suffering.
            </p>
            <h4>Официальный перевод</h4>
            <p>
                Но когда пал могучий Титан и ужас объял армии Судьбы, жрецы- демоны из Храмов Крови устроили ловушку на Палача Рока. Не удовлетворившись даже победой над Великим, искал Путник Ада новых жертв в гробницах Кровавой твердыни. И зашел в ловушку, ослепленный рвением своим. Обрушили жрецы храм на Палача Рока, и погребли его, побежденного, под проклятым саркофагом. Печать Палача Рока была выжжена на его гробнице — предупреждение всему аду, что не должен быть никогда освобожден ужас, что сокрыт внутри. Там и лежит он, недвижимый, в безмолвных муках.
            </p>
        </div>

    </section>
@endsection
