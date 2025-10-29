<?php

namespace Database\Seeders;

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
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DefaultShelvesSeeder::class,
        ]);

        User::factory()->admin()->create([
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        // Незалежні моделі (створюємо першими)
        User::factory(5)->create();
        Genre::factory(15)->create();
        Publisher::factory(10)->create();
        Store::factory(5)->create();
        Tag::factory(30)->create();
        Award::factory(10)->create();
        BookSeries::factory(10)->create();

        // Моделі зі зв’язками
        Author::factory(30)->create();
        Book::factory(100)->create();
        Group::factory(10)->create();
        Shelf::factory(30)->create();
        Collection::factory(20)->create();

        // Пов’язані з книгами та авторами
        Character::factory(100)->create();
        AuthorQuestion::factory(50)->create();
        AuthorAnswer::factory(40)->create();
        BookOffer::factory(100)->create();
        Nomination::factory(10)->create();
        NominationEntry::factory(30)->create();
        UserBook::factory(200)->create();
        Note::factory(100)->create();
        Quote::factory(50)->create();
        Rating::factory(150)->create();
        ReadingStat::factory(20)->create();

        // Пов’язані з групами
        GroupEvent::factory(20)->create();
        GroupPost::factory(100)->create();
        GroupPoll::factory(10)->create();
        PollOption::factory(30)->create();
        PollVote::factory(100)->create();
        GroupInvitation::factory(50)->create();
        EventRsvp::factory(100)->create();
        GroupModerationLog::factory(20)->create();

        // Поліморфні зв’язки
        Post::factory(100)->create();
        Comment::factory(300)->create();
        Like::factory(500)->create();
        Favorite::factory(200)->create();
        Report::factory(20)->create();
        ViewHistory::factory(500)->create();
    }
}
