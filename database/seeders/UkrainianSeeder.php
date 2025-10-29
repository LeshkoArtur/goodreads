<?php

namespace Database\Seeders;

use App\Enums\AgeRestriction;
use App\Enums\AnswerStatus;
use App\Enums\BookLanguage;
use App\Enums\CoverType;
use App\Enums\Currency;
use App\Enums\EventResponse;
use App\Enums\EventStatus;
use App\Enums\Gender;
use App\Enums\InvitationStatus;
use App\Enums\JoinPolicy;
use App\Enums\MemberRole;
use App\Enums\MemberStatus;
use App\Enums\ModerationAction;
use App\Enums\NominationStatus;
use App\Enums\OfferStatus;
use App\Enums\PostCategory;
use App\Enums\PostPolicy;
use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Enums\QuestionStatus;
use App\Enums\ReadingFormat;
use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Enums\Role;
use App\Enums\TypeOfWork;
use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use App\Models\Award;
use App\Models\Book;
use App\Models\BookOffer;
use App\Models\BookSeries;
use App\Models\Character;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\EventRsvp;
use App\Models\Favorite;
use App\Models\Genre;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\GroupInvitation;
use App\Models\GroupModerationLog;
use App\Models\GroupPoll;
use App\Models\GroupPost;
use App\Models\Like;
use App\Models\Nomination;
use App\Models\NominationEntry;
use App\Models\Note;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\Post;
use App\Models\Publisher;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\ReadingStat;
use App\Models\Report;
use App\Models\Shelf;
use App\Models\Store;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserBook;
use App\Models\ViewHistory;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UkrainianSeeder extends Seeder
{
    /**
     * Seed the application's database with Ukrainian content.
     */
    public function run(): void
    {
        // Disable foreign key checks for seeding (PostgreSQL syntax)
        DB::statement('SET session_replication_role = replica;');

        // Clear existing data
        $this->clearExistingData();

        $this->call([
            SuperAdminSeeder::class,
            DefaultShelvesSeeder::class,
        ]);

        // Create Ukrainian genres
        $ukrainianGenres = [
            ['name' => 'Українська класика', 'description' => 'Класична українська література'],
            ['name' => 'Сучасна українська проза', 'description' => 'Сучасні українські романи та новели'],
            ['name' => 'Українська поезія', 'description' => 'Українські поети та поеми'],
            ['name' => 'Українська історична проза', 'description' => 'Романи, засновані на українській історії'],
            ['name' => 'Українська фантастика', 'description' => 'Фантастичні твори українських авторів'],
            ['name' => 'Дитяча українська література', 'description' => 'Дитячі книги українською мовою'],
            ['name' => 'Українські казки', 'description' => 'Народні та авторські українські казки'],
            ['name' => 'Український триллер', 'description' => 'Трилери українських авторів'],
            ['name' => 'Український детектив', 'description' => 'Детективи українських авторів'],
            ['name' => 'Український романтика', 'description' => 'Романтичні твори українських авторів'],
            ['name' => 'Українська драма', 'description' => 'Драматичні твори українських авторів'],
            ['name' => 'Український жартівливий жанр', 'description' => 'Гумористичні твори українських авторів'],
            ['name' => 'Українська наукова фантастика', 'description' => 'Наукова фантастика українських авторів'],
            ['name' => 'Український фентезі', 'description' => 'Фентезі українських авторів'],
            ['name' => 'Український містика', 'description' => 'Містичні твори українських авторів'],
        ];

        foreach ($ukrainianGenres as $genre) {
            Genre::factory()->create([
                'name' => $genre['name'],
                'description' => $genre['description'],
            ]);
        }

        // Create Ukrainian publishers
        $ukrainianPublishers = [
            ['name' => 'А-ба-ба-га-ла-ма-га', 'country' => 'Україна'],
            ['name' => 'Видавництво "Клуб Сімейного Дозвілля"', 'country' => 'Україна'],
            ['name' => 'Фоліо', 'country' => 'Україна'],
            ['name' => 'Акцент', 'country' => 'Україна'],
            ['name' => 'КСД', 'country' => 'Україна'],
            ['name' => 'Піраміда', 'country' => 'Україна'],
            ['name' => 'Навчальна книга - Богдан', 'country' => 'Україна'],
            ['name' => 'Екзамен', 'country' => 'Україна'],
            ['name' => 'Гріф', 'country' => 'Україна'],
            ['name' => 'Пентагон', 'country' => 'Україна'],
        ];

        foreach ($ukrainianPublishers as $publisher) {
            Publisher::factory()->create([
                'name' => $publisher['name'],
                'country' => $publisher['country'],
            ]);
        }

        // Create Ukrainian stores
        $ukrainianStores = [
            ['name' => 'Книгарня "Книжковий Клуб"', 'region' => 'Київ', 'website_url' => 'https://bookclub.ua'],
            ['name' => 'Книгарня "Корній"', 'region' => 'Львів', 'website_url' => 'https://korniy.lviv.ua'],
            ['name' => 'Книгарня "Смолоскип"', 'region' => 'Київ', 'website_url' => 'https://smoloskyp.ua'],
            ['name' => 'Книгарня "Глобус"', 'region' => 'Харків', 'website_url' => 'https://globus.ua'],
            ['name' => 'Книгарня "Еконт', 'region' => 'Одеса', 'website_url' => 'https://ekont.ua'],
        ];

        foreach ($ukrainianStores as $store) {
            Store::factory()->create([
                'name' => $store['name'],
                'region' => $store['region'],
                'website_url' => $store['website_url'],
            ]);
        }

        // Create Ukrainian tags
        $ukrainianTags = [
            ['name' => 'Українська література'],
            ['name' => 'Сучасність'],
            ['name' => 'Класика'],
            ['name' => 'Поезія'],
            ['name' => 'Проза'],
            ['name' => 'Дитяча література'],
            ['name' => 'Українські автори'],
            ['name' => 'Казки'],
            ['name' => 'Фантастика'],
            ['name' => 'Фентезі'],
            ['name' => 'Історична проза'],
            ['name' => 'Драма'],
            ['name' => 'Романтика'],
            ['name' => 'Трилер'],
            ['name' => 'Детектив'],
            ['name' => 'Бестселери'],
            ['name' => 'Новинки'],
            ['name' => 'Премії'],
            ['name' => 'Переклади'],
            ['name' => 'Орігінали'],
            ['name' => 'Література для дітей'],
            ['name' => 'Література для підлітків'],
            ['name' => 'Наукова фантастика'],
            ['name' => 'Містика'],
            ['name' => 'Пригоди'],
            ['name' => 'Психологія'],
            ['name' => 'Філософія'],
            ['name' => 'Релігія'],
            ['name' => 'Культура'],
            ['name' => 'Мистецтво'],
        ];

        foreach ($ukrainianTags as $tag) {
            Tag::factory()->create([
                'name' => $tag['name'],
            ]);
        }

        // Create Ukrainian awards
        $ukrainianAwards = [
            ['name' => 'Літературна премія імені Івана Франка', 'description' => 'Щорічна премія за найкращу художню книгу'],
            ['name' => 'Літературна премія імені Лесі Українки', 'description' => 'Премія за досягнення в поезії'],
            ['name' => 'Премія "Книжка року"', 'description' => 'Найкраща книга року за версією видавців'],
            ['name' => 'Премія "Коронація слова"', 'description' => 'Найважливіша літературна премія України'],
            ['name' => 'Премія імені Михайла Коцюбинського', 'description' => 'За досягнення в прозі'],
            ['name' => 'Премія імені Тараса Шевченка', 'description' => 'Найвища державна літературна премія'],
            ['name' => 'Премія "Героям бути"', 'description' => 'За внесок у формування національної свідомості'],
            ['name' => 'Премія "Золотий півень"', 'description' => 'За найкращі дитячі книжки'],
            ['name' => 'Премія "Слово перемоги"', 'description' => 'За твори, присвячені темі війни та героїзму'],
            ['name' => 'Премія "Слово про мову"', 'description' => 'За внесок у розвиток української мови'],
        ];

        foreach ($ukrainianAwards as $award) {
            Award::factory()->create([
                'name' => $award['name'],
                'description' => $award['description'],
            ]);
        }

        // Create Ukrainian book series
        $ukrainianSeries = [
            ['name' => 'Слово про рідну землю', 'description' => 'Цикл творів про українські землі'],
            ['name' => 'Історична спадщина', 'description' => 'Романи про історію України'],
            ['name' => 'Сучасні голоси', 'description' => 'Твори сучасних українських авторів'],
            ['name' => 'Дитячі казки', 'description' => 'Казки українських письменників'],
            ['name' => 'Поетична Україна', 'description' => 'Збірки поезії українських поетів'],
            ['name' => 'Фантастична Україна', 'description' => 'Фантастичні твори українських авторів'],
            ['name' => 'Дорогою мрій', 'description' => 'Книги для підлітків'],
            ['name' => 'Літературна криниця', 'description' => 'Класична українська література'],
            ['name' => 'Крок у майбутнє', 'description' => 'Науково-фантастичні твори'],
            ['name' => 'Спадщина предків', 'description' => 'Твори про українські традиції'],
        ];

        foreach ($ukrainianSeries as $series) {
            BookSeries::factory()->create([
                'title' => $series['name'],
                'description' => $series['description'],
            ]);
        }

        // Create Ukrainian users with Ukrainian names and locations
        $ukrainianUsernames = [
            'ivan_kovalenko', 'oksana_melnyk', 'dmytro_sydorov', 'natalia_bondarenko',
            'andriy_petrenko', 'maria_havryliuk', 'volodymyr_kovalchuk', 'olena_bilyk',
            'mykola_shevchenko', 'tetiana_stetsenko', 'serhiy_koval', 'iryna_zaytseva',
            'pavlo_moroz', 'kateryna_borysenko', 'oleksandr_kovalenko', 'anastasiia_sokol',
            'yuriy_lysenko', 'viktoria_andriychuk', 'roman_hryshchenko', 'yaroslava_bilous',
        ];

        $ukrainianLocations = [
            'Київ', 'Харків', 'Одеса', 'Дніпро', 'Донецьк', 'Львів', 'Запоріжжя',
            'Кривий Ріг', 'Миколаїв', 'Маріуполь', 'Сєвєродонецьк', 'Луганськ',
            'Віниця', 'Макіївка', 'Сімферополь', 'Херсон', 'Полтава', 'Чернігів',
            'Житомир', 'Суми', 'Рівне', 'Івано-Франківськ', 'Кам\'янське', 'Кропивницький',
        ];

        $users = User::factory(20)->create();
        $usernameIndex = 0;

        foreach ($users as $user) {
            $username = $ukrainianUsernames[$usernameIndex % count($ukrainianUsernames)];
            $usernameIndex++;

            $user->update([
                'username' => $username,
                'location' => $ukrainianLocations[array_rand($ukrainianLocations)],
                'email' => $user->email ?? strtolower(str_replace(' ', '_', $user->name ?? 'user')).'@ukr.net',
                'role' => Factory::create()->randomElement(Role::cases()),
                'gender' => Factory::create()->randomElement(Gender::cases()),
            ]);
        }

        // Create Ukrainian authors with Ukrainian names and backgrounds
        $ukrainianAuthors = [
            [
                'name' => 'Лесі Українка',
                'bio' => 'Лариса Косач-Квітка, відома під псевдонімом Лесі Українки, — українська письменниця, поетеса, драматург, перекладачка, публіцистка.',
                'birth_place' => 'Новоград-Волинський',
                'nationality' => 'Українська',
                'type_of_work' => 'poet',
            ],
            [
                'name' => 'Тарас Шевченко',
                'bio' => 'Український поет, письменник, художник, мислитель, філософ, фольклорист, публіцист, громадський діяч.',
                'birth_place' => 'Моринці',
                'nationality' => 'Українська',
                'type_of_work' => 'poet',
            ],
            [
                'name' => 'Іван Франко',
                'bio' => 'Український письменник, поет, драматург, історик літератури, мовознавець, перекладач, перекладач, соціолог, етнограф, громадський та політичний діяч.',
                'birth_place' => 'Нагуєвичі',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Михайло Коцюбинський',
                'bio' => 'Український письменник, один із засновників української літератури модернізму.',
                'birth_place' => 'Віниця',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Володимир Винниченко',
                'bio' => 'Український письменник, художник, політичний діяч, один із лідерів українського національно-визвольного руху.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Микола Хвильовий',
                'bio' => 'Український радянський письменник, поет, драматург, перекладач, громадський діяч.',
                'birth_place' => 'Сілікатне',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Олесь Гончар',
                'bio' => 'Український радянський письменник, перекладач, громадський діяч.',
                'birth_place' => 'Чернівці',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Василь Стус',
                'bio' => 'Український поет, письменник, перекладач, правозахисник, дисидент.',
                'birth_place' => 'Семигори',
                'nationality' => 'Українська',
                'type_of_work' => 'poet',
            ],
            [
                'name' => 'Ліна Костенко',
                'bio' => 'Українська поетеса, прозаїчка, перекладачка, громадська діячка.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'poet',
            ],
            [
                'name' => 'Оксана Забужко',
                'bio' => 'Українська письменниця, поетеса, феміністка, культурологиня, дисидентка.',
                'birth_place' => 'Фастів',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Юрій Винничук',
                'bio' => 'Український письменник, перекладач, редактор, громадський діяч.',
                'birth_place' => 'Львів',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Оксана Прохасько',
                'bio' => 'Українська письменниця, перекладачка, літературна критичка.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Андрій Кокотюха',
                'bio' => 'Український письменник, перекладач, редактор.',
                'birth_place' => 'Львів',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Олена Філатова',
                'bio' => 'Українська письменниця, перекладачка, літературознавиця.',
                'birth_place' => 'Харків',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Сергій Жадан',
                'bio' => 'Український поет, прозаїк, перекладач, перформанс-артист, педагог.',
                'birth_place' => 'Старий Сальтів',
                'nationality' => 'Українська',
                'type_of_work' => 'poet',
            ],
            [
                'name' => 'Марія Матіос',
                'bio' => 'Українська письменниця, поетеса, перекладачка.',
                'birth_place' => 'Свалява',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Юрій Іванюк',
                'bio' => 'Український письменник, перекладач, редактор.',
                'birth_place' => 'Коломия',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Олена Лукаш',
                'bio' => 'Українська письменниця, перекладачка, літературознавиця.',
                'birth_place' => 'Львів',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Василь Аksamit',
                'bio' => 'Український письменник, поет, перекладач.',
                'birth_place' => 'Свалява',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Василь Шкляр',
                'bio' => 'Український письменник, перекладач, педагог, публіцист.',
                'birth_place' => 'Підгайці',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Борис Олійник',
                'bio' => 'Український письменник, перекладач, редактор.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Олександр Ірванець',
                'bio' => 'Український письменник, перекладач, редактор.',
                'birth_place' => 'Свалява',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Микола Романчук',
                'bio' => 'Український письменник, перекладач.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Олена Пушкар',
                'bio' => 'Українська письменниця, перекладачка.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Роман Сенкевич',
                'bio' => 'Український письменник, сценарист.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Олена Вороненко',
                'bio' => 'Українська письменниця, перекладачка.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Андрій Коваленко',
                'bio' => 'Український письменник, поет, перекладач.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Олена Степаненко',
                'bio' => 'Українська письменниця, перекладачка.',
                'birth_place' => 'Львів',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Володимир Романюк',
                'bio' => 'Український письменник, перекладач.',
                'birth_place' => 'Львів',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
            [
                'name' => 'Наталія Стадник',
                'bio' => 'Українська письменниця, перекладачка.',
                'birth_place' => 'Київ',
                'nationality' => 'Українська',
                'type_of_work' => 'novelist',
            ],
        ];

        foreach ($ukrainianAuthors as $authorData) {
            Author::factory()->create([
                'name' => $authorData['name'],
                'bio' => $authorData['bio'],
                'birth_place' => $authorData['birth_place'],
                'nationality' => $authorData['nationality'],
                'type_of_work' => $authorData['type_of_work'],
            ]);
        }

        // Create additional Ukrainian authors with Ukrainian Faker locale
        Author::factory(50)->create()->each(function ($author) {
            $ukrainianNames = [
                'Олександр Довженко', 'Михайло Стельмах', 'Василь Григорович', 'Олена Пчілка',
                'Іван Нечуй-Левицький', 'Пантелеймон Куліш', 'Марко Вовчок', 'Іван Котляревський',
                'Григорій Квітка-Основ\'яненко', 'Павло Загребельний', 'Михайло Старицький',
                'Олена Теліга', 'Валер\'ян Підмогильний', 'Микола Хвильовий', 'Микола Куліш',
                'Михайло Яловой', 'Володимир Чапель', 'Андрій Малишко', 'Володимир Дрозд',
                'Олесь Honchar', 'Василь Михайленко', 'Андрій Білий', 'Володимир Івасюк',
                'Василь Кучер', 'Борис Олійник', 'Василь Пачовський', 'Микола Хвильовий',
                'Олександр Довбуш', 'Григорій Тютюнник', 'Василь Земляк', 'Олена Демівна',
                'Михайло Ващенко-Захарченко', 'Олена Пчілка', 'Олена Аура', 'Олена Біляна',
                'Андрій Кочерга', 'Володимир Маяковський', 'Олена Степаненко', 'Володимир Романюк',
                'Наталія Стадник', 'Олександр Ірванець', 'Микола Романчук', 'Олена Пушкар',
                'Роман Сенкевич', 'Олена Вороненко', 'Андрій Коваленко', 'Олена Степаненко',
                'Володимир Романюк', 'Наталія Стадник', 'Олександр Ірванець', 'Микола Романчук',
                'Олена Пушкар', 'Роман Сенкевич', 'Олена Вороненко', 'Андрій Коваленко',
            ];

            $author->update([
                'name' => $ukrainianNames[array_rand($ukrainianNames)],
                'nationality' => 'Українська',
                'birth_place' => $this->getRandomUkrainianCity(),
                'type_of_work' => Factory::create()->randomElement(TypeOfWork::cases()),
            ]);
        });

        // Create Ukrainian books with Ukrainian titles and content
        $ukrainianBooks = [
            [
                'title' => 'Лісова пісня',
                'description' => 'Поетична драма Лесі Українки про кохання лісових і водяних істот.',
                'plot' => 'Історія кохання лісника Мавки до водяного Пасічника.',
                'history' => 'Написана у 1911 році, є однією з найвідоміших драматичних поем Лесі Українки.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Одна з найпопулярніших українських драматичних поем', 'Неодноразово екранізована']),
            ],
            [
                'title' => 'Кобзар',
                'description' => 'Збірка поезій Тараса Шевченка, що стала фундаментом української літератури.',
                'plot' => 'Збірка поезій, що відображають життя українського народу.',
                'history' => 'Перший збірник поезій Тараса Шевченка, опублікований у 1840 році.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Один з найдорожчих літературних творів в історії України', 'Поклав початок новій ері української літератури']),
            ],
            [
                'title' => 'Захар Беркут',
                'description' => 'Історична новела Івана Франка про боротьбу українського народу проти монголів.',
                'plot' => 'Події відбуваються в XIII столітті, коли монголи вторгаються в українські землі.',
                'history' => 'Опублікована в 1883 році, стала однією з перших історичних новел української літератури.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Екранізована кілька разів', 'Символ українського патріотизму']),
            ],
            [
                'title' => 'Хіба ревуть воли, як ясла повні?',
                'description' => 'Роман Івана Нечуя-Левицького про життя селян у Галичині.',
                'plot' => 'Роман про соціальні конфлікти та життя селянства у другій половині XIX століття.',
                'history' => 'Опублікований у 1880 році, став першим українським соціальним романом.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Перший український соціальний роман', 'Мав величезний вплив на українське національне відродження']),
            ],
            [
                'title' => 'Енеїда',
                'description' => 'Сатирична поема Івана Котляревського - перший твір української літератури у новій українській літературній мові.',
                'plot' => 'Пародія на епічну поему Вергілія про пригоди Енея, перенесені в український контекст.',
                'history' => 'Написана в 1798 році, стала першим твором нової української літературної мови.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Перший твір нової української літературної мови', 'Поклала початок українській національній літературі']),
            ],
            [
                'title' => 'Сад Гетсиманський',
                'description' => 'Роман Михайла Коцюбинського про духовні пошуки молодого інтелігента.',
                'plot' => 'Роман про душевні пошуки та моральні випробування молодого українського інтелігента.',
                'history' => 'Опублікований у 1908 році, є одним з найважливіших творів українського модернізму.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Один з найважливіших творів українського модернізму', 'Написаний в експресіоністичному стилі']),
            ],
            [
                'title' => 'Камінний хрест',
                'description' => 'Роман Олесі Гончара про пошук духовного відродження.',
                'plot' => 'Історія про зв\'язок між минулим і сучасністю, про духовне відродження народу.',
                'history' => 'Опублікований у 1969 році, став одним з найважливіших творів сучасної української літератури.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Номінований на Нобелівську премію', 'Перекладений багатьма мовами світу']),
            ],
            [
                'title' => 'Маруся',
                'description' => 'Поема Лесі Українки про трагічне кохання української дівчини.',
                'plot' => 'Трагічна історія кохання Марусі, дівчини з бідної родини, до барона.',
                'history' => 'Написана у 1895 році, є однією з найвідоміших поем Лесі Українки.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Одна з найвідоміших поем Лесі Українки', 'Неодноразово екранізована']),
            ],
            [
                'title' => 'Я (Романтика)',
                'description' => 'Роман Оксани Забужко про жіночу ідентичність у пострадянській Україні.',
                'plot' => 'Історія жінки, що шукає себе в новій епохі та новій країні.',
                'history' => 'Опублікований у 1996 році, став однією з найважливіших книг української літератури ХХ століття.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Один з найдорожчих українських романів останніх років', 'Перекладений багатьма мовами світу']),
            ],
            [
                'title' => 'Святозар',
                'description' => 'Роман Володимира Винниченка про революційні події в Україні.',
                'plot' => 'Події революції та боротьби за незалежність України.',
                'history' => 'Опублікований у 1902 році, є важливим твором української революційної літератури.',
                'languages' => collect([BookLanguage::UK]),
                'fun_facts' => collect(['Один з перших українських революційних романів', 'Мав величезний вплив на український національний рух']),
            ],
        ];

        foreach ($ukrainianBooks as $bookData) {
            Book::factory()->create([
                'title' => $bookData['title'],
                'description' => $bookData['description'],
                'plot' => $bookData['plot'],
                'history' => $bookData['history'],
                'languages' => [fake()->randomElement(BookLanguage::cases())],
                'fun_facts' => $bookData['fun_facts'],
                'age_restriction' => fake()->randomElement(AgeRestriction::cases()),
            ]);
        }

        // Create additional Ukrainian books with Ukrainian Faker locale
        Book::factory(100)->create()->each(function ($book) {
            $ukrainianTitles = [
                'Світло зорі', 'Сонце в павутинні', 'Тіні забутих предків', 'Місто',
                'Ніж живе слово', 'Золотий ліс', 'Повернення', 'Земля', 'Пісня',
                'Сади мого життя', 'Сльози і крик', 'Дід Мороз і Червона Шапочка',
                'Пригоди Буратіно', 'Маленький принц', 'Пісні кобзаря', 'Слово про рід',
                'Світло і тіні', 'Весна людська', 'Поле чудес', 'Танок на сонці',
                'Дощові дні', 'Світанок над рікою', 'Сад моїх мрій', 'Світло душі',
                'Серце України', 'Дім мого дитинства', 'Мандрівка до зорі', 'Повітря вільності',
                'Світло в темряві', 'Вітер зі сходу', 'Слово моєї батьківщини', 'Мрії та надії',
                'Квіти весни', 'Сонячні дні', 'Місячна ніч', 'Зоря надії', 'Світло зорі',
                'Сонце в павутинні', 'Тіні забутих предків', 'Місто', 'Ніж живе слово',
                'Золотий ліс', 'Повернення', 'Земля', 'Пісня', 'Сади мого життя',
                'Сльози і крик', 'Дід Мороз і Червона Шапочка', 'Пригоди Буратіно',
                'Маленький принц', 'Пісні кобзаря', 'Слово про рід', 'Світло і тіні',
                'Весна людська', 'Поле чудес', 'Танок на сонці', 'Дощові дні',
                'Світанок над рікою', 'Сад моїх мрій', 'Світло душі', 'Серце України',
                'Дім мого дитинства', 'Мандрівка до зорі', 'Повітря вільності',
                'Світло в темряві', 'Вітер зі сходу', 'Слово моєї батьківщини', 'Мрії та надії',
                'Квіти весни', 'Сонячні дні', 'Місячна ніч', 'Зоря надії', 'Світло зорі',
                'Сонце в павутинні', 'Тіні забутих предків', 'Місто', 'Ніж живе слово',
                'Золотий ліс', 'Повернення', 'Земля', 'Пісня', 'Сади мого життя',
                'Сльози і крик', 'Дід Мороз і Червона Шапочка', 'Пригоди Буратіно',
                'Маленький принц', 'Пісні кобзаря', 'Слово про рід', 'Світло і тіні',
                'Весна людська', 'Поле чудес', 'Танок на сонці', 'Дощові дні',
                'Світанок над рікою', 'Сад моїх мрій', 'Світло душі', 'Серце України',
                'Дім мого дитинства', 'Мандрівка до зорі', 'Повітря вільності',
                'Світло в темряві', 'Вітер зі сходу', 'Слово моєї батьківщини', 'Мрії та надії',
                'Квіти весни', 'Сонячні дні', 'Місячна ніч', 'Зоря надії', 'Світло зорі',
                'Сонце в павутинні', 'Тіні забутих предків', 'Місто', 'Ніж живе слово',
                'Золотий ліс', 'Повернення', 'Земля', 'Пісня', 'Сади мого життя',
                'Сльози і крик', 'Дід Мороз і Червона Шапочка', 'Пригоди Буратіно',
                'Маленький принц', 'Пісні кобзаря', 'Слово про рід', 'Світло і тіні',
                'Весна людська', 'Поле чудес', 'Танок на сонці', 'Дощові дні',
                'Світанок над рікою', 'Сад моїх мрій', 'Світло душі', 'Серце України',
            ];

            $book->update([
                'title' => $ukrainianTitles[array_rand($ukrainianTitles)],
                'languages' => collect(BookLanguage::UK),
            ]);
        });

        // Create popular foreign books to complement Ukrainian content
        $foreignBooks = [
            [
                'title' => '1984',
                'description' => 'Роман-антиутопія Джорджа Орвелла про тоталітарне майбутнє.',
                'plot' => 'Історія про Вінстона Сміта, який намагається протистояти придушливій владі Великого Брату.',
                'history' => 'Опублікований у 1949 році, це одне з найвідоміших творів Орвелла.',
                'languages' => collect(['en', BookLanguage::UK]),
                'fun_facts' => collect(['Назва походить від року написання, перевернутого', 'Книга внесена до списку найважливіших творів XX століття']),
            ],
            [
                'title' => 'Гаррі Поттер і філософський камінь',
                'description' => 'Перший роман у серії про юного відьмака Гаррі Поттера.',
                'plot' => 'Дванадцятирічний Гаррі дізнається, що він відьмак, і вступає до школи чаклунства Хогвортс.',
                'history' => 'Опублікований у 197 році, став першим у сімичастій серії.',
                'languages' => collect(['en', BookLanguage::UK]),
                'fun_facts' => collect(['Написаний під час важкої життєвої ситуації для автора', 'Перекладений понад 80 мовами']),
            ],
            [
                'title' => 'Гра престолів',
                'description' => 'Перший роман у серії "Пісня Льоду й Вогню" Джорджа Р. Р. Мартина.',
                'plot' => 'Складна політична інтрига та боротьба за Залізний трон у вигаданому світі Вестеросу.',
                'history' => 'Опублікований у 196 році, став основою для популярного серіалу.',
                'languages' => collect(['en', BookLanguage::UK]),
                'fun_facts' => collect(['Відомий своєю непередбачуваністю та смертю головних героїв', 'Перекладений більш ніж 45 мовами']),
            ],
            [
                'title' => 'Володар перснів: Братиство персня',
                'description' => 'Перший роман у трилогії про Всевладний перстень у вигаданому світі.',
                'plot' => 'Подорож Фродо Бегінса та Братерства Персня для знищення Всевладного персня.',
                'history' => 'Опублікований у 1954 році, є одним з найвідоміших творів фентезі.',
                'languages' => collect(['en', BookLanguage::UK]),
                'fun_facts' => collect(['Написаний як самостійна історія, але пізніше розділений на три частини', 'Один із найвпливовіших творів жанру фентезі']),
            ],
            [
                'title' => 'Гамлет',
                'description' => 'Трагедія Вільяма Шекспіра про принца Данії.',
                'plot' => 'Принц Гамлет шукає помсту за вбивство свого батька, короля Данії.',
                'history' => 'Написаний приблизно в 1600 році, є однією з найвідоміших п\'єс Шекспіра.',
                'languages' => collect(['en', BookLanguage::UK]),
                'fun_facts' => collect(['Містить відому фразу "Бути чи не бути, ось в чому питання"', 'Одна з найвідоміших п\'єс у світовій літературі']),
            ],
            [
                'title' => 'Майстер і Маргарита',
                'description' => 'Роман Михайла Булгакова про візит Сатани до радянської Москви.',
                'plot' => 'Історія про Воланда та його супутників, які відвідують Москву, та про роман Майстра та Маргарити.',
                'history' => 'Написаний у 1928-1940 роках, був опублікований лише в 1966-1967 роках.',
                'languages' => collect(['ru', BookLanguage::UK]),
                'fun_facts' => collect(['Був прихований від радянської цензури багато років', 'Вважається шедевром світової літератури']),
            ],
            [
                'title' => 'Преступление и наказание',
                'description' => 'Роман Федора Достоєвського про психологічні муки та моральні випробування.',
                'plot' => 'Історія про Родіона Раскольнікова, який вбиває стару процентницю і стикається з наслідками.',
                'history' => 'Опублікований у 1866 році, є одним з найвідоміших творів Достоєвського.',
                'languages' => collect(['ru', BookLanguage::UK]),
                'fun_facts' => collect(['Один з перших психологічних романів у літературі', 'Вплинув на розвиток жанру кримінальної літератури']),
            ],
            [
                'title' => 'Три товарищи',
                'description' => 'Роман Еріха Марії Ремарка про дружбу трьох друзів у міжвоєнній Німеччині.',
                'plot' => 'Історія про дружбу, кохання та втрати в епоху соціальних змін.',
                'history' => 'Опублікований у 1936 році, був заборонений у Німеччині нацистами.',
                'languages' => collect(['de', BookLanguage::UK]),
                'fun_facts' => collect(['Один з найпопулярніших романів Ремарка', 'Книга була спалена нацистами']),
            ],
            [
                'title' => 'Мобі Дік',
                'description' => 'Роман Германа Мелвіля про мисливця на китів.',
                'plot' => 'Історія про капітана Ахава, який переслідує білого кита Мобі Діка.',
                'history' => 'Опублікований у 1851 році, вважається класикою американської літератури.',
                'languages' => collect(['en', BookLanguage::UK]),
                'fun_facts' => collect(['Перші 135 сторінок описують життя на китобійному судні', 'Один з найдовших романів у світовій літературі']),
            ],
            [
                'title' => 'Воїн світла',
                'description' => 'Роман Пауло Коельйо про пошук власного шляху та мети життя.',
                'plot' => 'Історія про юного пастуха, який вирушає у пошуках скарбу, а знаходить більше, ніж очікував.',
                'history' => 'Опублікований у 1988 році, є однією з найпопулярніших книг сучасності.',
                'languages' => collect(['pt', BookLanguage::UK]),
                'fun_facts' => collect(['Перекладений більш ніж 80 мовами', 'Один з найпопулярніших романів усіх часів']),
            ],
        ];

        foreach ($foreignBooks as $bookData) {
            Book::factory()->create([
                'title' => $bookData['title'],
                'description' => $bookData['description'],
                'plot' => $bookData['plot'],
                'history' => $bookData['history'],
                'languages' => fake()->randomElements(BookLanguage::cases()),
                'fun_facts' => $bookData['fun_facts'],
            ]);
        }

        // Create additional foreign books
        $moreForeignBooks = [
            'To Kill a Mockingbird', 'Pride and Prejudice', 'The Great Gatsby', 'The Catcher in the Rye',
            'Lord of the Flies', 'Brave New World', 'The Lord of the Rings', 'The Hobbit',
            'Fahrenheit 451', 'Jane Eyre', 'Wuthering Heights', 'Alice\'s Adventures in Wonderland',
            'The Chronicles of Narnia', 'Charlie and the Chocolate Factory', 'The Little Prince',
            'The Alchemist', 'The Kite Runner', 'Life of Pi', 'The Book Thief',
            'The Hunger Games', 'Divergent', 'The Fault in Our Stars', 'Me Before You',
            'Gone Girl', 'The Girl on the Train', 'Big Little Lies', 'The Da Vinci Code',
            'Angels & Demons', 'Inferno', 'Digital Fortress', 'The Pillars of the Earth',
            'World Without End', 'The Boys in the Boat', 'Unbroken', 'Wild',
            'The Paris Wife', 'The Hemingway Girl', 'A Moveable Feast', 'The Sun Also Rises',
            'For Whom the Bell Tolls', 'The Old Man and the Sea', 'A Farewell to Arms',
            'The Great Gatsby', 'The Beautiful and Damned', 'Tender Is the Night', 'This Side of Paradise',
            'The Grapes of Wrath', 'Of Mice and Men', 'East of Eden', 'Cannery Row',
            'The Pearl', 'The Winter of Our Discontent', 'The Adventures of Huckleberry Finn',
            'The Adventures of Tom Sawyer', 'A Connecticut Yankee in King Arthur\'s Court', 'The Prince and the Pauper',
            'The Celebrated Jumping Frog of Calaveras County', 'The Call of the Wild', 'White Fang',
            'The Sea-Wolf', 'Martin Eden', 'The Iron Heel', 'The Road to Serfdom',
            'The Constitution of Liberty', 'Law, Legislation and Liberty', 'The Fatal Conceit',
            'The Origin of Species', 'The Descent of Man', 'The Voyage of the Beagle', 'On the Origin of Species',
            'The Republic', 'The Symposium', 'Phaedo', 'Meno', 'Apology', 'Crito', 'Phaedrus',
            'The Clouds', 'The Wasps', 'The Frogs', 'The Birds', 'Lysistrata', 'The Acharnians',
            'The Knights', 'The Thesmophoriazusae', 'The Ecclesiazusae', 'The Peace', 'The Wasps',
            'The Poetics', 'The Politics', 'Nicomachean Ethics', 'Metaphysics', 'Physics', 'On the Soul',
            'The Iliad', 'The Odyssey', 'Theogony', 'Works and Days', 'The Shield of Heracles',
            'The Argonautica', 'The Aeneid', 'Metamorphoses', 'The Golden Ass', 'Satyricon',
            'The Divine Comedy', 'The Decameron', 'The Canzoniere', 'The Prince', 'The Art of War',
            'The Analects', 'Tao Te Ching', 'The Art of War', 'The Romance of the Three Kingdoms',
            'Journey to the West', 'Dream of the Red Chamber', 'Water Margin', 'The Pillow Book',
            'The Tale of Genji', 'Manyōshū', 'The Kokinshū', 'The Man\'s Man', 'The Tale of the Bamboo Cutter',
            'The Kojiki', 'The Nihon Shoki', 'The Fudoki', 'The Kogo Shūi', 'The Nihon Kōki',
            'The Shoku Nihongi', 'The Shoku Kōji-ryaku', 'The Nihon Sandai Jitsuroku', 'The Shōryaku',
            'The Chūyūki', 'The Kin\'yō Wakashū', 'The Shinkokinshū', 'The Jittō Wakashū',
            'The Shin\'you Wakashū', 'The Bunki Wakashū', 'The Kenchō Kakukyō', 'The Kenjō Jūnen',
        ];

        foreach ($moreForeignBooks as $title) {
            Book::factory()->create([
                'title' => $title,
                'languages' => collect(BookLanguage::EN),
            ]);
        }

        // Get all created entities
        $allBooks = Book::all();
        $allAuthors = Author::all();
        $allGenres = Genre::all();
        $allPublishers = Publisher::all();
        $allSeries = BookSeries::all();
        $allUsers = User::all();
        $allGroups = Group::all();
        $allTags = Tag::all();
        $allCharacters = Character::all();

        // Create relationships between authors and books
        foreach ($allBooks as $book) {
            // Each book can have 1-3 authors
            $authorsForBook = $allAuthors->random(rand(1, 3));
            if ($authorsForBook instanceof Author) {
                $book->authors()->attach($authorsForBook->id);
            } else {
                foreach ($authorsForBook as $author) {
                    $book->authors()->attach($author->id);
                }
            }
        }

        // Create relationships between books and genres
        foreach ($allBooks as $book) {
            // Each book can belong to 1-2 genres
            $genresForBook = $allGenres->random(rand(1, 2));
            if ($genresForBook instanceof Genre) {
                $book->genres()->attach($genresForBook->id);
            } else {
                foreach ($genresForBook as $genre) {
                    $book->genres()->attach($genre->id);
                }
            }
        }

        // Create relationships between books and publishers
        $coverTypes = CoverType::cases();

        foreach ($allBooks as $book) {
            // Each book can have 1 publisher
            $publisher = $allPublishers->random();
            $book->publishers()->attach($publisher->id, [
                'price' => rand(50, 500), // Adding a random price between 50 and 500
                'cover_type' => fake()->randomElement($coverTypes), // Adding a random cover type
            ]);
        }

        // Create relationships between books and series
        foreach ($allBooks as $book) {
            // Some books belong to a series
            if (rand(0, 1)) { // 50% chance
                $series = $allSeries->random();
                $book->series()->associate($series);
                $book->save();
            }
        }

        // Create relationships between users and groups
        foreach ($allGroups as $group) {
            // Each group has multiple members
            $members = $allUsers->random(rand(3, 10));
            foreach ($members as $user) {
                $group->members()->attach($user->id, [
                    'role' => fake()->randomElement(MemberRole::cases()),
                    'status' => fake()->randomElement(MemberStatus::cases()),
                    'joined_at' => fake()->dateTimeThisYear(),
                ]);
            }
        }

        // Create relationships for user shelves - each user book can be assigned to a shelf
        foreach ($allUsers as $user) {
            // Each user has multiple shelves
            $existingShelves = Shelf::where('user_id', $user->id)->get();
            if ($existingShelves->count() == 0) {
                // Create shelves for the user if they don't exist
                $shelfNames = ['Want to Read', 'Currently Reading', 'Read', 'Favorites', 'To Buy'];
                $numShelves = rand(2, 5);
                for ($i = 0; $i < min($numShelves, count($shelfNames)); $i++) {
                    Shelf::factory()->create([
                        'user_id' => $user->id,
                        'name' => $shelfNames[$i],
                    ]);
                }
                $existingShelves = Shelf::where('user_id', $user->id)->get();
            }

            // Assign some books to shelves through the user_books relationship
            $userBooks = $allBooks->random(rand(10, 30));
            foreach ($userBooks as $book) {
                $shelf = $existingShelves->random();
                // Check if the user-book combination already exists
                $existingRecord = DB::table('user_books')
                    ->where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->first();

                if (! $existingRecord) {
                    DB::table('user_books')->insert([
                        'id' => Str::uuid(),
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'shelf_id' => $shelf->id,
                        'reading_format' => fake()->randomElement(ReadingFormat::cases()),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Create Ukrainian collections first before using them in relationships
        $ukrainianCollections = [
            ['name' => 'Українські бестселери', 'description' => 'Найпопулярніші українські книги'],
            ['name' => 'Казки для дітей', 'description' => 'Народні та авторські українські казки'],
            ['name' => 'Жіночі голоси', 'description' => 'Твори українських жінок-письменниць'],
            ['name' => 'Преміальні твори', 'description' => 'Книги, що отримали літературні премії'],
            ['name' => 'Поезія та драма', 'description' => 'Поетичні та драматургічні твори'],
            ['name' => 'Нові обрії', 'description' => 'Експериментальна українська література'],
            ['name' => 'Визвольна тема', 'description' => 'Твори про незалежність та свободу'],
            ['name' => 'Сучасні відкриття', 'description' => 'Молоді українські автори'],
            ['name' => 'Література опору', 'description' => 'Твори, написані під час війни'],
            ['name' => 'Класична поезія', 'description' => 'Класична українська поезія'],
        ];

        foreach ($ukrainianCollections as $collection) {
            Collection::factory()->create([
                'title' => $collection['name'],
                'description' => $collection['description'],
            ]);
        }

        // Get all collections after they are created
        $allCollections = Collection::all();

        // Create relationships for user collections
        foreach ($allUsers as $user) {
            // Each user has multiple collections
            $collections = $allCollections->random(rand(1, 3));
            foreach ($collections as $collection) {
                $booksForCollection = $allBooks->random(rand(3, 15));
                foreach ($booksForCollection as $book) {
                    // Check if the relationship already exists to avoid duplicate key violations
                    $existingRecord = DB::table('book_collection')
                        ->where('collection_id', $collection->id)
                        ->where('book_id', $book->id)
                        ->first();

                    if (! $existingRecord) {
                        DB::table('book_collection')->insert([
                            'collection_id' => $collection->id,
                            'book_id' => $book->id,
                            'created_at' => fake()->dateTimeThisYear(),
                            'updated_at' => fake()->dateTimeThisYear(),
                        ]);
                    }
                }
            }
        }

        // Create relationships for user-book interactions
        foreach ($allUsers as $user) {
            // Each user has interacted with multiple books
            $userBooks = $allBooks->random(rand(10, 30));
            foreach ($userBooks as $book) {
                // Check if the user-book relationship already exists to avoid duplicate key violations
                $existingRecord = DB::table('user_books')
                    ->where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->first();

                if (! $existingRecord) {
                    // Get or create a shelf for this user
                    $shelf = Shelf::where('user_id', $user->id)->first();
                    if (! $shelf) {
                        $shelf = Shelf::factory()->create([
                            'user_id' => $user->id,
                            'name' => 'Default Shelf',
                        ]);
                    }

                    // Create user-book relationship
                    DB::table('user_books')->insert([
                        'id' => Str::uuid(),
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'shelf_id' => $shelf->id,
                        'reading_format' => fake()->randomElement(ReadingFormat::cases()),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Create ratings for some books
                if (rand(0, 1)) { // 50% chance
                    // Check if rating already exists to avoid duplicate key violations
                    $existingRating = Rating::where('user_id', $user->id)
                        ->where('book_id', $book->id)
                        ->first();

                    if (! $existingRating) {
                        Rating::factory()->create([
                            'user_id' => $user->id,
                            'book_id' => $book->id,
                            'rating' => rand(1, 5),
                        ]);
                    }
                }

                // Create notes for some books
                if (rand(0, 2) === 0) { // 33% chance
                    // Check if note already exists to avoid duplicate key violations
                    $existingNote = Note::where('user_id', $user->id)
                        ->where('book_id', $book->id)
                        ->first();

                    if (! $existingNote) {
                        Note::factory()->create([
                            'user_id' => $user->id,
                            'book_id' => $book->id,
                        ]);
                    }
                }

                // Create quotes for some books
                if (rand(0, 3) === 0) { // 25% chance
                    Quote::factory()->create([
                        'book_id' => $book->id,
                    ]);
                }
            }
        }

        // Create relationships for tags
        foreach ($allBooks as $book) {
            // Each book can have multiple tags
            $tagsForBook = $allTags->random(rand(1, 4));
            foreach ($tagsForBook as $tag) {
                DB::table('taggables')->insert([
                    'tag_id' => $tag->id,
                    'taggable_type' => 'App\Models\Book',
                    'taggable_id' => $book->id,
                ]);
            }
        }

        // Create relationships for comments
        foreach ($allUsers as $user) {
            // Each user creates multiple comments
            $commentables = ['book', 'post', 'group', 'author'];
            $numComments = rand(5, 15);
            for ($i = 0; $i < $numComments; $i++) {
                $commentableType = 'App\\Models\\'.ucfirst(fake()->randomElement($commentables));
                $commentableId = null; // Initialize as null

                switch ($commentableType) {
                    case 'App\Models\Book':
                        if ($allBooks->count() > 0) {
                            $randomBook = $allBooks->random();
                            $commentableId = $randomBook ? $randomBook->id : null;
                        } else {
                            $randomBook = Book::inRandomOrder()->first();
                            $commentableId = $randomBook ? $randomBook->id : null;
                        }
                        break;
                    case 'App\Models\Post':
                        $randomPost = Post::inRandomOrder()->first();
                        $commentableId = $randomPost ? $randomPost->id : null;
                        break;
                    case 'App\Models\Group':
                        if ($allGroups->count() > 0) {
                            $randomGroup = $allGroups->random();
                            $commentableId = $randomGroup ? $randomGroup->id : null;
                        } else {
                            $randomGroup = Group::inRandomOrder()->first();
                            $commentableId = $randomGroup ? $randomGroup->id : null;
                        }
                        break;
                    case 'App\Models\Author':
                        if ($allAuthors->count() > 0) {
                            $randomAuthor = $allAuthors->random();
                            $commentableId = $randomAuthor ? $randomAuthor->id : null;
                        } else {
                            $randomAuthor = Author::inRandomOrder()->first();
                            $commentableId = $randomAuthor ? $randomAuthor->id : null;
                        }
                        break;
                }

                // Only create the comment if we have a valid commentableId
                if ($commentableId) {
                    Comment::factory()->create([
                        'user_id' => $user->id,
                        'commentable_type' => $commentableType,
                        'commentable_id' => $commentableId,
                    ]);
                }
            }
        }

        // Create relationships for likes
        foreach ($allUsers as $user) {
            // Each user creates multiple likes
            $likeables = ['book', 'post', 'comment', 'quote'];
            $numLikes = rand(10, 30);
            for ($i = 0; $i < $numLikes; $i++) {
                $likeableType = 'App\\Models\\'.ucfirst(fake()->randomElement($likeables));
                $likeableId = null; // Initialize as null

                switch ($likeableType) {
                    case 'App\Models\Book':
                        if ($allBooks->count() > 0) {
                            $randomBook = $allBooks->random();
                            $likeableId = $randomBook ? $randomBook->id : null;
                        } else {
                            $randomBook = Book::inRandomOrder()->first();
                            $likeableId = $randomBook ? $randomBook->id : null;
                        }
                        break;
                    case 'App\Models\Post':
                        $randomPost = Post::inRandomOrder()->first();
                        $likeableId = $randomPost ? $randomPost->id : null;
                        break;
                    case 'App\Models\Comment':
                        $randomComment = Comment::inRandomOrder()->first();
                        $likeableId = $randomComment ? $randomComment->id : null;
                        break;
                    case 'App\Models\Quote':
                        $randomQuote = Quote::inRandomOrder()->first();
                        $likeableId = $randomQuote ? $randomQuote->id : null;
                        break;
                }

                // Only create the like if we have a valid likeableId and it doesn't already exist
                if ($likeableId) {
                    // Check if this like already exists to avoid duplicate key violations
                    $existingLike = DB::table('likes')
                        ->where('user_id', $user->id)
                        ->where('likeable_id', $likeableId)
                        ->where('likeable_type', $likeableType)
                        ->first();

                    if (! $existingLike) {
                        Like::factory()->create([
                            'user_id' => $user->id,
                            'likeable_type' => $likeableType,
                            'likeable_id' => $likeableId,
                        ]);
                    }
                }
            }
        }

        // Create relationships for favorites
        foreach ($allUsers as $user) {
            // Each user has multiple favorites
            $favoriteables = ['book', 'author', 'group'];
            $numFavorites = rand(5, 15);
            for ($i = 0; $i < $numFavorites; $i++) {
                $favoriteableType = 'App\\Models\\'.ucfirst(fake()->randomElement($favoriteables));
                $favoriteableId = null; // Initialize as null

                switch ($favoriteableType) {
                    case 'App\Models\Book':
                        if ($allBooks->count() > 0) {
                            $randomBook = $allBooks->random();
                            $favoriteableId = $randomBook ? $randomBook->id : null;
                        } else {
                            $randomBook = Book::inRandomOrder()->first();
                            $favoriteableId = $randomBook ? $randomBook->id : null;
                        }
                        break;
                    case 'App\Models\Author':
                        if ($allAuthors->count() > 0) {
                            $randomAuthor = $allAuthors->random();
                            $favoriteableId = $randomAuthor ? $randomAuthor->id : null;
                        } else {
                            $randomAuthor = Author::inRandomOrder()->first();
                            $favoriteableId = $randomAuthor ? $randomAuthor->id : null;
                        }
                        break;
                    case 'App\Models\Group':
                        if ($allGroups->count() > 0) {
                            $randomGroup = $allGroups->random();
                            $favoriteableId = $randomGroup ? $randomGroup->id : null;
                        } else {
                            $randomGroup = Group::inRandomOrder()->first();
                            $favoriteableId = $randomGroup ? $randomGroup->id : null;
                        }
                        break;
                }

                // Only create the favorite if we have a valid favoriteableId and it doesn't already exist
                if ($favoriteableId) {
                    // Check if this favorite already exists to avoid duplicate key violations
                    $existingFavorite = DB::table('favorites')
                        ->where('user_id', $user->id)
                        ->where('favoriteable_id', $favoriteableId)
                        ->where('favoriteable_type', $favoriteableType)
                        ->first();

                    if (! $existingFavorite) {
                        Favorite::factory()->create([
                            'user_id' => $user->id,
                            'favoriteable_type' => $favoriteableType,
                            'favoriteable_id' => $favoriteableId,
                        ]);
                    }
                }
            }
        }

        // Create relationships for character-book connections
        foreach ($allCharacters as $character) {
            // Each character appears in 1-3 books
            $booksForCharacter = $allBooks->random(rand(1, 3));
            foreach ($booksForCharacter as $book) {
                $character->books()->attach($book->id);
            }
        }

        // Create relationships for author questions and answers
        foreach ($allAuthors as $author) {
            // Each author has multiple questions
            $numQuestions = rand(2, 5);
            for ($i = 0; $i < $numQuestions; $i++) {
                AuthorQuestion::factory()->create([
                    'author_id' => $author->id,
                ]);
            }
        }

        // Create relationships for nominations
        foreach ($allBooks as $book) {
            // Some books are nominated for awards
            if (rand(0, 3) === 0) { // 25% chance
                $nomination = Nomination::inRandomOrder()->first();
                if ($nomination) {
                    NominationEntry::factory()->create([
                        'book_id' => $book->id,
                        'nomination_id' => $nomination->id,
                    ]);
                }
            }
        }

        // Create relationships for book offers
        foreach ($allBooks as $book) {
            // Some books are available in stores
            if (rand(0, 1)) { // 50% chance
                $store = Store::inRandomOrder()->first();
                if ($store) {
                    BookOffer::factory()->create([
                        'book_id' => $book->id,
                        'store_id' => $store->id,
                    ]);
                }
            }
        }

        // Create Ukrainian groups
        $ukrainianGroups = [
            ['name' => 'Книжковий клуб "Літературна Україна"', 'description' => 'Обговорення української літератури'],
            ['name' => 'Фан-клуб Лесі Українки', 'description' => 'Шанувальники творчості Лесі Українки'],
            ['name' => 'Читачі сучасної прози', 'description' => 'Обговорення сучасної української прози'],
            ['name' => 'Поетична душа', 'description' => 'Група любителів поезії'],
            ['name' => 'Дитяча література', 'description' => 'Батьки та педагоги, що цікавляться дитячою літературою'],
            ['name' => 'Фантастична Україна', 'description' => 'Фанати української фантастики'],
            ['name' => 'Історична література', 'description' => 'Прихильники історичних романів'],
            ['name' => 'Кіберпанк Україна', 'description' => 'Фанати кіберпанку українською'],
            ['name' => 'Феміністична література', 'description' => 'Обговорення творів українських жінок-письменниць'],
            ['name' => 'ЛГБТК+ література', 'description' => 'Прихильники різноманітності в українській літературі'],
        ];

        foreach ($ukrainianGroups as $group) {
            Group::factory()->create([
                'name' => $group['name'],
                'description' => $group['description'],
                'join_policy' => fake()->randomElement(JoinPolicy::cases()),
                'post_policy' => fake()->randomElement(PostPolicy::cases()),
            ]);
        }

        // Create Ukrainian shelves
        $ukrainianShelves = [
            ['name' => 'Українська класика', 'description' => 'Класична українська література'],
            ['name' => 'Сучасні українські автори', 'description' => 'Твори сучасних українських письменників'],
            ['name' => 'Українська поезія', 'description' => 'Поетичні збірки українських авторів'],
            ['name' => 'Дитячі улюбленці', 'description' => 'Українські дитячі книги'],
            ['name' => 'Читаю зараз', 'description' => 'Книги, що зараз читаю'],
            ['name' => 'Хочу прочитати', 'description' => 'Плани на майбутнє читання'],
            ['name' => 'Улюблена фантастика', 'description' => 'Українська наукова фантастика'],
            ['name' => 'Історичні романи', 'description' => 'Українські історичні твори'],
            ['name' => 'Доречі цитати', 'description' => 'Книги з цікавими цитатами'],
            ['name' => 'Нові надходження', 'description' => 'Нещодавно придбані українські книги'],
        ];

        foreach ($ukrainianShelves as $shelf) {
            Shelf::factory()->create([
                'name' => $shelf['name'],
            ]);
        }

        // Create Ukrainian characters
        $ukrainianCharacters = [
            ['name' => 'Мавка', 'description' => 'Лісова німфа з однойменної драми Лесі Українки'],
            ['name' => 'Пасічник', 'description' => 'Водяний з драми "Лісова пісня" Лесі Українки'],
            ['name' => 'Захар Беркут', 'description' => 'Головний герой однойменної новели Івана Франка'],
            ['name' => 'Тугар Вовк', 'description' => 'Боярин з новели "Захар Беркут"'],
            ['name' => 'Кайдаш', 'description' => 'Герой новели Івана Нечуя-Левицького'],
            ['name' => 'Микола', 'description' => 'Головний герой роману "Хіба ревуть воли, як ясла повні?"'],
            ['name' => 'Тарас', 'description' => 'Герой поеми "Кобзар" Тараса Шевченка'],
            ['name' => 'Маруся', 'description' => 'Головна героїня однойменної поеми Лесі Українки'],
            ['name' => 'Оксана', 'description' => 'Героїня поеми "Кобзар" Тараса Шевченка'],
            ['name' => 'Рудь', 'description' => 'Герой поеми "Кобзар" Тараса Шевченка'],
            ['name' => 'Гнат', 'description' => 'Герой новели "Тіні забутих предків" Михайла Коцюбинського'],
            ['name' => 'Мирослава', 'description' => 'Героїня новели "Тіні забутих предків" Михайла Коцюбинського'],
            ['name' => 'Соломія', 'description' => 'Героїня новели "Тіні забутих предків" Михайла Коцюбинського'],
            ['name' => 'Борис', 'description' => 'Герой новели "Тіні забутих предків" Михайла Коцюбинського'],
            ['name' => 'Андрій', 'description' => 'Герой новели "Тіні забутих предків" Михайла Коцюбинського'],
            ['name' => 'Микола', 'description' => 'Герой новели "Сад Гетсиманський" Михайла Коцюбинського'],
            ['name' => 'Федора', 'description' => 'Героїня новели "Сад Гетсиманський" Михайла Коцюбинського'],
            ['name' => 'Наталка', 'description' => 'Героїня драми "Наталка Полтавка" Івана Котляревського'],
            ['name' => 'Грицько', 'description' => 'Герой драми "Наталка Полтавка" Івана Котляревського'],
            ['name' => 'Полтавка', 'description' => 'Героїня драми "Наталка Полтавка" Івана Котляревського'],
        ];

        foreach ($ukrainianCharacters as $character) {
            Character::factory()->create([
                'name' => $character['name'],
            ]);
        }

        // Create additional characters with Ukrainian names
        Character::factory(80)->create()->each(function ($character) {
            $ukrainianNames = [
                'Оксана', 'Марія', 'Галина', 'Наталія', 'Олена', 'Ірина', 'Тетяна', 'Віра',
                'Світлана', 'Юлія', 'Дарина', 'Анна', 'Катерина', 'Валентина', 'Ольга',
                'Володимир', 'Олександр', 'Микола', 'Іван', 'Петро', 'Марко', 'Сергій',
                'Андрій', 'Дмитро', 'Роман', 'Юрій', 'Богдан', 'Ярослав', 'Василь',
                'Михайло', 'Олег', 'Артем', 'Борис', 'Віктор', 'Євген', 'Степан',
                'Федір', 'Максим', 'Тарас', 'Левко', 'Лесик', 'Микита', 'Руслан',
                'Ігор', 'В\'ячеслав', 'Едуард', 'Валерій', 'Мстислав', 'Ян', 'Данило',
                'Богдан', 'Ростислав', 'Всеволод', 'Святослав', 'Ярослав', 'Орест',
                'Людмила', 'Надія', 'Зоряна', 'Аліна', 'Вікторія', 'Марина', 'Євдокія',
                'Сніжана', 'Весна', 'Зірка', 'Рада', 'Соломія', 'Христина', 'Мирослава',
                'Ярослава', 'Орися', 'Палажка', 'Діяна', 'Варвара', 'Олесія', 'Агрипина',
                'Анастасія', 'Євгенія', 'Валерія', 'Діана', 'Мілена', 'Таїсія', 'Уляна',
            ];

            $character->update([
                'name' => $ukrainianNames[array_rand($ukrainianNames)],
            ]);
        });

        // Create Ukrainian author questions and answers
        $questions = [
            'Як виникла ідея для вашої найвідомішої книги?',
            'Який український письменник найбільше вплинув на вашу творчість?',
            'Як ви відчуваєте себе частиною української літературної традиції?',
            'Як війна вплинула на ваше письменництво?',
            'Який радите український роман для першого знайомства з сучасною українською літературою?',
            'Як ви думаєте, чому важливо читати українських авторів?',
            'Які українські міфологічні мотиви ви використовуєте у своїх творах?',
            'Як ви бачите майбутнє української літератури?',
            'Які теми в українській літературі ви вважаєте недооціненими?',
            'Як ви ставитеся до перекладів своїх творів іншими мовами?',
        ];

        $answers = [
            'Ідея прийшла під час прогулянки лісом, коли я згадав дитячі казки бабусі.',
            'На мене величезний вплив справив Тарас Шевченко та його глибоке розуміння народу.',
            'Я відчуваю себе продовжувачем великої української літературної традиції.',
            'Війна змінила все - мову, стиль, важливість слів та їх зміст.',
            'Для початку читання української літератури раджу "Маруся" Лесі Українки.',
            'Читати українських авторів - це зберігати мову та культуру нашого народу.',
            'Я часто звертаюся до образів лісових духів та української міфології.',
            'Майбутнє української літератури - у поєднанні традицій та сучасних форм.',
            'Недооціненою вважаю тему жіночості в українській літературі.',
            'Переклади моїх творів дозволяють світу дізнатися українську літературу.',
        ];

        for ($i = 0; $i < 50; $i++) {
            $author = Author::all()->random();
            AuthorQuestion::factory()->create([
                'author_id' => $author->id,
                'content' => $questions[array_rand($questions)],
                'status' => fake()->randomElement(QuestionStatus::cases()),
            ]);
        }

        for ($i = 0; $i < 40; $i++) {
            $question = AuthorQuestion::all()->random();
            AuthorAnswer::factory()->create([
                'question_id' => $question->id,
                'content' => $answers[array_rand($answers)],
                'status' => fake()->randomElement(AnswerStatus::cases()),
            ]);
        }

        // Create Ukrainian nominations
        $ukrainianNominations = [
            ['name' => 'Найкраща українська поезія', 'description' => 'Номінація для найкращої поетичної збірки'],
            ['name' => 'Найкращий український роман', 'description' => 'Номінація для найкращого роману'],
            ['name' => 'Найкраща дитяча книга', 'description' => 'Номінація для найкращої дитячої книги'],
            ['name' => 'Найкращий дебют', 'description' => 'Номінація для найкращого дебютного твору'],
            ['name' => 'Найкращий переклад', 'description' => 'Номінація для найкращого перекладу українською'],
            ['name' => 'Найкраща історична проза', 'description' => 'Номінація для найкращого історичного роману'],
            ['name' => 'Найкраща фантастика', 'description' => 'Номінація для найкращого фантастичного твору'],
            ['name' => 'Найкраща феміністична література', 'description' => 'Номінація для творів, що піднімають жіночі теми'],
            ['name' => 'Найкраща література опору', 'description' => 'Номінація для творів, присвячених війні'],
            ['name' => 'Найкраща експериментальна проза', 'description' => 'Номінація для інноваційних літературних форм'],
        ];

        foreach ($ukrainianNominations as $nomination) {
            Nomination::factory()->create([
                'name' => $nomination['name'],
                'description' => $nomination['description'],
            ]);
        }

        // Create nomination entries
        for ($i = 0; $i < 30; $i++) {
            $book = Book::all()->random();
            $nomination = Nomination::all()->random();
            NominationEntry::factory()->create([
                'book_id' => $book->id,
                'nomination_id' => $nomination->id,
                'status' => fake()->randomElement(NominationStatus::cases()),
            ]);
        }

        // Create Ukrainian book offers
        $books = Book::all();
        $stores = Store::all();
        $createdCombinations = [];

        // Create up to 100 unique book offer combinations
        $attempts = 0;
        $maxAttempts = 200; // Prevent infinite loop

        while (count($createdCombinations) < 100 && $attempts < $maxAttempts) {
            $book = $books->random();
            $store = $stores->random();

            // Create a unique key for this combination
            $combinationKey = $book->id.'|'.$store->id;

            // Only create the offer if this combination hasn't been created yet
            if (! in_array($combinationKey, $createdCombinations)) {
                // Check if this combination already exists in the database
                $existingOffer = DB::table('book_offers')
                    ->where('book_id', $book->id)
                    ->where('store_id', $store->id)
                    ->first();

                if (! $existingOffer) {
                    BookOffer::factory()->create([
                        'book_id' => $book->id,
                        'store_id' => $store->id,
                        'price' => rand(10, 2000),
                        'currency' => fake()->randomElement(Currency::cases()),
                        'status' => fake()->randomElement(OfferStatus::cases()),
                    ]);
                }

                // Track this combination to prevent duplicates
                $createdCombinations[] = $combinationKey;
            }

            $attempts++;
        }

        // Create user books relationships
        for ($i = 0; $i < 200; $i++) {
            $user = User::all()->random();
            $book = Book::all()->random();

            // Check if the user-book relationship already exists to avoid duplicate key violations
            $existingRecord = DB::table('user_books')
                ->where('user_id', $user->id)
                ->where('book_id', $book->id)
                ->first();

            if (! $existingRecord) {
                $shelf = Shelf::where('user_id', $user->id)->inRandomOrder()->first();
                if (! $shelf) {
                    $shelf = Shelf::factory()->create([
                        'user_id' => $user->id,
                        'name' => 'Default Shelf',
                    ]);
                }
                UserBook::factory()->create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'shelf_id' => $shelf->id,
                ]);
            }
        }

        // Create notes
        for ($i = 0; $i < 100; $i++) {
            $user = User::all()->random();
            $book = Book::all()->random();
            Note::factory()->create([
                'user_id' => $user->id,
                'book_id' => $book->id,
            ]);
        }

        // Create quotes
        $ukrainianQuotes = [
            'Слово - це думка, виправдана на ділі. (Леся Українка)',
            'Якби сльози могли змінити долю, ніщо б не змінилося. (Тарас Шевченко)',
            'Мову свою не втрачай, коли іншою володієш. (Іван Драч)',
            'Любов до Батьківщини - початок усієї чесноти. (Тарас Шевченко)',
            'Не в силах ворог зламати ні слави, ні душі, ні мови. (Леся Українка)',
            'Слово вільне, як птах небесний. (Леся Українка)',
            'Я вас убив, але не вб\'ю вашого слова. (Тарас Шевченко)',
            'Де б не був, як не заблудив би, всюди я рідну землю чую. (Василь Стус)',
            'Будь ласка, бережіть мову! (Ліна Костенко)',
            'Українська мова - це не просто мова, це святиня. (Олесь Гончар)',
            'Мова - душа народу. (Іван Франко)',
            'Книга - душа народу. (Тарас Шевченко)',
            'Слово - це міст між душею і світом. (Оксана Забужко)',
            'Слово має владу над часом. (Леся Українка)',
            'Мова - це душа народу, його історія, його світогляд. (Іван Драч)',
            'Кожне слово - це крапля світла в темряві. (Василь Стус)',
            'Слово - це діло, а не порожня пастка. (Тарас Шевченко)',
            'Слово - це зброя, якою здобувають серця. (Леся Українка)',
            'Слово має владу над душею. (Олесь Гончар)',
            'Слово - це світло в темряві. (Іван Франко)',
        ];

        for ($i = 0; $i < 50; $i++) {
            $book = Book::all()->random();
            Quote::factory()->create([
                'book_id' => $book->id,
                'text' => $ukrainianQuotes[array_rand($ukrainianQuotes)],
            ]);
        }

        // Create ratings
        for ($i = 0; $i < 150; $i++) {
            $user = User::all()->random();
            $book = Book::all()->random();
            Rating::factory()->create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'rating' => rand(1, 5),
            ]);
        }

        // Create reading stats
        for ($i = 0; $i < 20; $i++) {
            $user = User::all()->random();
            ReadingStat::factory()->create([
                'user_id' => $user->id,
            ]);
        }

        // Create group events
        for ($i = 0; $i < 20; $i++) {
            $group = Group::all()->random();
            GroupEvent::factory()->create([
                'group_id' => $group->id,
                'status' => fake()->randomElement(EventStatus::cases()),
            ]);
        }

        // Create group posts
        for ($i = 0; $i < 100; $i++) {
            $group = Group::all()->random();
            $user = User::all()->random();
            GroupPost::factory()->create([
                'group_id' => $group->id,
                'user_id' => $user->id,
                'category' => fake()->randomElement(PostCategory::cases()),
                'post_status' => fake()->randomElement(PostStatus::cases()),
            ]);
        }

        // Create group polls
        for ($i = 0; $i < 10; $i++) {
            $group = Group::all()->random();
            $user = User::all()->random();
            GroupPoll::factory()->create([
                'group_id' => $group->id,
                'creator_id' => $user->id,
            ]);
        }

        // Create poll options
        for ($i = 0; $i < 30; $i++) {
            $poll = GroupPoll::all()->random();
            PollOption::factory()->create([
                'group_poll_id' => $poll->id,
            ]);
        }

        // Create poll votes
        for ($i = 0; $i < 100; $i++) {
            $option = PollOption::all()->random();
            $user = User::all()->random();
            PollVote::factory()->create([
                'poll_option_id' => $option->id,
                'user_id' => $user->id,
            ]);
        }

        // Create group invitations
        for ($i = 0; $i < 50; $i++) {
            $group = Group::all()->random();
            $user = User::all()->random();
            $invitee = User::all()->random();
            GroupInvitation::factory()->create([
                'group_id' => $group->id,
                'inviter_id' => $user->id,
                'invitee_id' => $invitee->id,
                'status' => fake()->randomElement(InvitationStatus::cases()),
            ]);
        }

        // Create event RSVPs
        for ($i = 0; $i < 100; $i++) {
            $event = GroupEvent::all()->random();
            $user = User::all()->random();

            // Check if this RSVP already exists to avoid duplicate key violations
            $existingRsvp = DB::table('event_rsvps')
                ->where('group_event_id', $event->id)
                ->where('user_id', $user->id)
                ->first();

            if (! $existingRsvp) {
                EventRsvp::factory()->create([
                    'group_event_id' => $event->id,
                    'user_id' => $user->id,
                    'response' => fake()->randomElement(EventResponse::cases()),
                ]);
            }
        }

        // Create group moderation logs
        for ($i = 0; $i < 20; $i++) {
            $group = Group::all()->random();
            $user = User::all()->random();
            GroupModerationLog::factory()->create([
                'group_id' => $group->id,
                'moderator_id' => $user->id,
                'action' => fake()->randomElement(ModerationAction::cases()),
            ]);
        }

        // Create posts
        for ($i = 0; $i < 100; $i++) {
            $user = User::all()->random();
            Post::factory()->create([
                'user_id' => $user->id,
                'type' => fake()->randomElement(PostType::cases()),
                'status' => fake()->randomElement(PostStatus::cases()),
            ]);
        }

        // Create comments
        for ($i = 0; $i < 300; $i++) {
            $user = User::all()->random();
            $models = ['book', 'post', 'group', 'author'];
            $model_type = 'App\\Models\\'.ucfirst($models[array_rand($models)]);
            $model_id = null;

            switch ($model_type) {
                case 'App\Models\Book':
                    $randomBook = Book::inRandomOrder()->first();
                    $model_id = $randomBook ? $randomBook->id : null;
                    break;
                case 'App\Models\Post':
                    $randomPost = Post::inRandomOrder()->first();
                    $model_id = $randomPost ? $randomPost->id : null;
                    break;
                case 'App\Models\Group':
                    $randomGroup = Group::inRandomOrder()->first();
                    $model_id = $randomGroup ? $randomGroup->id : null;
                    break;
                case 'App\Models\Author':
                    $randomAuthor = Author::inRandomOrder()->first();
                    $model_id = $randomAuthor ? $randomAuthor->id : null;
                    break;
            }

            // Only create the comment if we have a valid model_id
            if ($model_id) {
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'commentable_type' => $model_type,
                    'commentable_id' => $model_id,
                ]);
            }
        }

        // Create likes
        for ($i = 0; $i < 500; $i++) {
            $user = User::all()->random();
            $models = ['book', 'post', 'comment', 'quote'];
            $model_type = 'App\\Models\\'.ucfirst($models[array_rand($models)]);
            $model_id = null;

            switch ($model_type) {
                case 'App\Models\Book':
                    $randomBook = Book::inRandomOrder()->first();
                    $model_id = $randomBook ? $randomBook->id : null;
                    break;
                case 'App\Models\Post':
                    $randomPost = Post::inRandomOrder()->first();
                    $model_id = $randomPost ? $randomPost->id : null;
                    break;
                case 'App\Models\Comment':
                    $randomComment = Comment::inRandomOrder()->first();
                    $model_id = $randomComment ? $randomComment->id : null;
                    break;
                case 'App\Models\Quote':
                    $randomQuote = Quote::inRandomOrder()->first();
                    $model_id = $randomQuote ? $randomQuote->id : null;
                    break;
            }

            // Only create the like if we have a valid model_id and it doesn't already exist
            if ($model_id) {
                // Check if this like already exists to avoid duplicate key violations
                $existingLike = DB::table('likes')
                    ->where('user_id', $user->id)
                    ->where('likeable_id', $model_id)
                    ->where('likeable_type', $model_type)
                    ->first();

                if (! $existingLike) {
                    Like::factory()->create([
                        'user_id' => $user->id,
                        'likeable_type' => $model_type,
                        'likeable_id' => $model_id,
                    ]);
                }
            }
        }

        // Create favorites
        for ($i = 0; $i < 200; $i++) {
            $user = User::all()->random();
            $models = ['book', 'author', 'group'];
            $model_type = 'App\\Models\\'.ucfirst($models[array_rand($models)]);
            $model_id = null;

            switch ($model_type) {
                case 'App\Models\Book':
                    $randomBook = Book::inRandomOrder()->first();
                    $model_id = $randomBook ? $randomBook->id : null;
                    break;
                case 'App\Models\Author':
                    $randomAuthor = Author::inRandomOrder()->first();
                    $model_id = $randomAuthor ? $randomAuthor->id : null;
                    break;
                case 'App\Models\Group':
                    $randomGroup = Group::inRandomOrder()->first();
                    $model_id = $randomGroup ? $randomGroup->id : null;
                    break;
            }

            // Only create the favorite if we have a valid model_id and it doesn't already exist
            if ($model_id) {
                // Check if this favorite already exists to avoid duplicate key violations
                $existingFavorite = DB::table('favorites')
                    ->where('user_id', $user->id)
                    ->where('favoriteable_id', $model_id)
                    ->where('favoriteable_type', $model_type)
                    ->first();

                if (! $existingFavorite && $model_id) {
                    Favorite::factory()->create([
                        'user_id' => $user->id,
                        'favoriteable_type' => $model_type,
                        'favoriteable_id' => $model_id,
                    ]);
                }
            }
        }

        // Create reports
        for ($i = 0; $i < 20; $i++) {
            $user = User::all()->random();
            $models = ['book', 'post', 'comment', 'author'];
            $model_type = 'App\\Models\\'.ucfirst($models[array_rand($models)]);
            $model_id = null;

            switch ($model_type) {
                case 'App\Models\Book':
                    $randomBook = Book::inRandomOrder()->first();
                    $model_id = $randomBook ? $randomBook->id : null;
                    break;
                case 'App\Models\Post':
                    $randomPost = Post::inRandomOrder()->first();
                    $model_id = $randomPost ? $randomPost->id : null;
                    break;
                case 'App\Models\Comment':
                    $randomComment = Comment::inRandomOrder()->first();
                    $model_id = $randomComment ? $randomComment->id : null;
                    break;
                case 'App\Models\Author':
                    $randomAuthor = Author::inRandomOrder()->first();
                    $model_id = $randomAuthor ? $randomAuthor->id : null;
                    break;
            }

            // Only create the report if we have a valid model_id
            if ($model_id) {
                Report::factory()->create([
                    'user_id' => $user->id,
                    'reportable_type' => $model_type,
                    'reportable_id' => $model_id,
                    'type' => fake()->randomElement(ReportType::cases()),
                    'status' => fake()->randomElement(ReportStatus::cases()),
                ]);
            }
        }

        // Create view histories
        for ($i = 0; $i < 500; $i++) {
            $user = User::all()->random();
            $models = ['book', 'author', 'post', 'group'];
            $model_type = 'App\\Models\\'.ucfirst($models[array_rand($models)]);
            $model_id = null;

            switch ($model_type) {
                case 'App\Models\Book':
                    $randomBook = Book::inRandomOrder()->first();
                    $model_id = $randomBook ? $randomBook->id : null;
                    break;
                case 'App\Models\Author':
                    $randomAuthor = Author::inRandomOrder()->first();
                    $model_id = $randomAuthor ? $randomAuthor->id : null;
                    break;
                case 'App\Models\Post':
                    $randomPost = Post::inRandomOrder()->first();
                    $model_id = $randomPost ? $randomPost->id : null;
                    break;
                case 'App\Models\Group':
                    $randomGroup = Group::inRandomOrder()->first();
                    $model_id = $randomGroup ? $randomGroup->id : null;
                    break;
            }

            // Only create the view history if we have a valid model_id and it doesn't already exist
            if ($model_id) {
                // Check if this view history already exists to avoid duplicate key violations
                $existingViewHistory = DB::table('view_histories')
                    ->where('user_id', $user->id)
                    ->where('viewable_id', $model_id)
                    ->where('viewable_type', $model_type)
                    ->first();

                if (! $existingViewHistory) {
                    ViewHistory::factory()->create([
                        'user_id' => $user->id,
                        'viewable_type' => $model_type,
                        'viewable_id' => $model_id,
                    ]);
                }
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET session_replication_role = DEFAULT;');
    }

    private function clearExistingData(): void
    {
        // Truncate all tables that will be seeded (PostgreSQL syntax)
        DB::statement('SET session_replication_role = replica;');

        DB::table('view_histories')->truncate();
        DB::table('reports')->truncate();
        DB::table('favorites')->truncate();
        DB::table('likes')->truncate();
        DB::table('comments')->truncate();
        DB::table('posts')->truncate();
        DB::table('group_moderation_logs')->truncate();
        DB::table('event_rsvps')->truncate();
        DB::table('group_invitations')->truncate();
        DB::table('poll_votes')->truncate();
        DB::table('poll_options')->truncate();
        DB::table('group_polls')->truncate();
        DB::table('group_posts')->truncate();
        DB::table('group_events')->truncate();
        DB::table('reading_stats')->truncate();
        DB::table('ratings')->truncate();
        DB::table('quotes')->truncate();
        DB::table('notes')->truncate();
        DB::table('user_books')->truncate();
        DB::table('book_offers')->truncate();
        DB::table('nomination_entries')->truncate();
        DB::table('nominations')->truncate();
        DB::table('author_answers')->truncate();
        DB::table('author_questions')->truncate();
        DB::table('characters')->truncate();
        DB::table('collections')->truncate();
        DB::table('book_collection')->truncate();
        DB::table('shelves')->truncate();
        DB::table('tags')->truncate();
        DB::table('taggables')->truncate();
        DB::table('reports')->truncate();
        DB::table('quotes')->truncate();
        DB::table('notes')->truncate();
        DB::table('user_books')->truncate();
        DB::table('book_publisher')->truncate();
        DB::table('author_book')->truncate();
        DB::table('book_genre')->truncate();
        DB::table('group_members')->truncate();
        DB::table('groups')->truncate();
        DB::table('awards')->truncate();
        DB::table('publishers')->truncate();
        DB::table('stores')->truncate();
        DB::table('authors')->truncate();
        DB::table('genres')->truncate();
        DB::table('books')->truncate();
        DB::table('book_series')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET session_replication_role = DEFAULT;');
    }

    private function getRandomUkrainianCity(): string
    {
        $cities = [
            'Київ', 'Харків', 'Одеса', 'Дніпро', 'Донецьк', 'Львів', 'Запоріжя',
            'Кривий Ріг', 'Миколаїв', 'Маріуполь', 'Сєвєродонецьк', 'Луганськ',
            'Віниця', 'Макіївка', 'Сімферополь', 'Херсон', 'Полтава', 'Чернігів',
            'Житомир', 'Суми', 'Рівне', 'Івано-Франківськ', 'Кам\'янське', 'Кропивницький',
            'Тернопіль', 'Луцьк', 'Краматорськ', 'Мелітополь', 'Слов\'янськ', 'Ужгород',
            'Бердичів', 'Нікополь', 'Алчевськ', 'Павлоград', 'Конотоп', 'Рівне',
            'Бровари', 'Бориспіль', 'Черкаси', 'Чортків', 'Переяслав', 'Бердянськ',
            'Нововолинськ', 'Коломия', 'Снятин', 'Коростень', 'Берегове', 'Свалява',
        ];

        return $cities[array_rand($cities)];
    }
}
