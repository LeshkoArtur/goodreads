<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use App\Models\Award;
use App\Models\Book;
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
use App\Models\Notification;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\Post;
use App\Models\Publisher;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\ReadingStat;
use App\Models\Report;
use App\Models\Shelf;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();

        User::factory(10)->create();
        Author::factory(10)->create();
        Book::factory(10)->create();
        Genre::factory(10)->create();
        Publisher::factory(10)->create();
        Shelf::factory(10)->create();
        Rating::factory(10)->create();
        Quote::factory(10)->create();
        Comment::factory(10)->create();
        Report::factory(10)->create();
        Tag::factory(10)->create();
        Taggable::factory(10)->create();
        Group::factory(10)->create();
        GroupPost::factory(10)->create();
        GroupEvent::factory(10)->create();
        EventRsvp::factory(10)->create();
        GroupPoll::factory(10)->create();
        PollOption::factory(10)->create();
        PollVote::factory(10)->create();
        Notification::factory(10)->create();
        AuthorQuestion::factory(10)->create();
        AuthorAnswer::factory(10)->create();
        GroupInvitation::factory(10)->create();
        GroupModerationLog::factory(10)->create();
        ViewHistory::factory(10)->create();
        Post::factory(10)->create();
        Like::factory(10)->create();
        ReadingStat::factory(10)->create();
        Award::factory(10)->create();
        Nomination::factory(10)->create();
        NominationEntry::factory(10)->create();
        Collection::factory(10)->create();
        UserBook::factory(10)->create();
        Character::factory(10)->create();
        Note::factory(10)->create();
        Favorite::factory(10)->create();
    }
}
