<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use App\Models\Award;
use App\Models\Book;
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
        $users = User::factory(10)->create();
        $authors = Author::factory(10)->create();
        $series = BookSeries::factory(5)->create();
        foreach ($authors as $author) {
            Book::factory(3)->create([
                'author_id' => $author->id,
                'series_id' => $series->random()->id,
            ]);
        }
        $books = Book::factory(10)->create();
        foreach ($books as $book) {
            $book->authors()->attach($authors->random(rand(1, 3))->pluck('id')->toArray());
        }
        $genres = Genre::factory(10)->create();
        $publishers = Publisher::factory(10)->create();
        foreach ($users as $user) {
            Shelf::factory(2)->create([
                'user_id' => $user->id,
            ]);
        }
        foreach ($users as $user) {
            Rating::factory(3)->create([
                'user_id' => $user->id,
                'book_id' => Book::inRandomOrder()->first()->id,
            ]);
        }

        foreach ($authors as $author) {
            Quote::factory(3)->create([
                'author_id' => $author->id,
                'book_id' => Book::inRandomOrder()->first()->id,
            ]);
        }
        foreach ($users as $user) {
            Comment::factory(3)->create([
                'user_id' => $user->id,
                'book_id' => Book::inRandomOrder()->first()->id,
            ]);
        }
        Report::factory(10)->create();
        Tag::factory(10)->create();
        Taggable::factory(10)->create();
        $groups = Group::factory(5)->create();
        foreach ($groups as $group) {
            GroupPost::factory(3)->create([
                'group_id' => $group->id,
            ]);
        }
        foreach ($groups as $group) {
            GroupEvent::factory(2)->create([
                'group_id' => $group->id,
            ]);
        }
        EventRsvp::factory(10)->create();
        foreach ($groups as $group) {
            GroupPoll::factory(2)->create([
                'group_id' => $group->id,
            ]);
        }
        foreach (GroupPoll::all() as $poll) {
            PollOption::factory(3)->create([
                'poll_id' => $poll->id,
            ]);
        }
        foreach (PollOption::all() as $option) {
            PollVote::factory(2)->create([
                'option_id' => $option->id,
            ]);
        }
        Notification::factory(10)->create();
        foreach ($authors as $author) {
            AuthorQuestion::factory(2)->create([
                'author_id' => $author->id,
            ]);
            AuthorAnswer::factory(2)->create([
                'author_id' => $author->id,
            ]);
        }
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
