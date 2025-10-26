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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Незалежні моделі (створюємо першими)
        User::factory(1)->create();
        /*Genre::factory(50)->create();
        Publisher::factory(30)->create();
        Store::factory(20)->create();
        Tag::factory(100)->create();
        Award::factory(50)->create();
        BookSeries::factory(50)->create();

        // Моделі зі зв’язками
        Author::factory(150)->create();
        Book::factory(500)->create();
        Group::factory(50)->create();
        Shelf::factory(300)->create();
        Collection::factory(100)->create();

        // Пов’язані з книгами та авторами
        Character::factory(1000)->create();
        AuthorQuestion::factory(500)->create();
        AuthorAnswer::factory(400)->create();
        BookOffer::factory(1000)->create();
        Nomination::factory(100)->create();
        NominationEntry::factory(300)->create();
        UserBook::factory(2000)->create();
        Note::factory(1000)->create();
        Quote::factory(500)->create();
        Rating::factory(1500)->create();
        ReadingStat::factory(200)->create();

        // Пов’язані з групами
        GroupEvent::factory(200)->create();
        GroupPost::factory(1000)->create();
        GroupPoll::factory(100)->create();
        PollOption::factory(300)->create();
        PollVote::factory(1000)->create();
        GroupInvitation::factory(500)->create();
        EventRsvp::factory(1000)->create();
        GroupModerationLog::factory(200)->create();

        // Поліморфні зв’язки
        Post::factory(1000)->create();
        Comment::factory(3000)->create();
        Like::factory(5000)->create();
        Favorite::factory(2000)->create();
        Report::factory(200)->create();
        ViewHistory::factory(5000)->create();*/
    }
}
