<?php

namespace Tests\Unit\Models;

use App\Enums\EventResponse;
use App\Enums\Gender;
use App\Enums\InvitationStatus;
use App\Enums\ReadingFormat;
use App\Enums\Role;
use App\Models\Author;
use App\Models\Book;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\GroupInvitation;
use App\Models\EventRsvp;
use App\Models\Post;
use App\Models\User;
use App\Models\Shelf;
use App\Models\UserBook;
use App\Models\Rating;
use App\Models\Quote;
use App\Models\Note;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Favorite;
use App\Models\ViewHistory;
use DateTimeInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields()
    {
        $user = new User();
        $this->assertEquals([
            'username',
            'email',
            'password',
            'email_verified_at',
            'profile_picture',
            'bio',
            'is_public',
            'birthday',
            'location',
            'last_login',
            'social_media_links',
            'role',
            'gender',
        ], $user->getFillable());
    }

    /** @test */
    public function it_hides_password_field()
    {
        $user = new User();
        $this->assertContains('password', $user->getHidden());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $user = User::factory()->make();

        $this->assertInstanceOf(DateTimeInterface::class, $user->email_verified_at);
        $this->assertIsBool($user->is_public);
        $this->assertInstanceOf(DateTimeInterface::class, $user->birthday);
        $this->assertInstanceOf(DateTimeInterface::class, $user->last_login);
        $this->assertIsIterable($user->social_media_links);
        $this->assertContains($user->role, Role::cases());
        $this->assertContains($user->gender, Gender::cases());
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_has_authors_relationship()
    {
        $user = User::factory()->create();
        $author = $user->authors()->create(['name' => 'Test Author']);
        $this->assertInstanceOf(Author::class, $user->authors->first());
        $this->assertEquals('Test Author', $author->name);
    }

    /** @test */
    public function it_has_shelves_relationship()
    {
        $user = User::factory()->create();
        $shelf = $user->shelves()->create(['name' => 'My Shelf']);
        $this->assertInstanceOf(Shelf::class, $user->shelves->first());
        $this->assertEquals('My Shelf', $shelf->name);
    }

    /** @test */
    public function it_has_books_relationship()
    {
        $user = User::factory()->create();
        $userBook = $user->books()->create([
            'book_id' => Book::factory()->create()->id,
            'shelf_id' => Shelf::factory()->create()->id,
            'rating' => 5,
            'reading_format' => ReadingFormat::AUDIOBOOK,
        ]);
        $this->assertInstanceOf(UserBook::class, $user->books->first());
        $this->assertEquals(5, $userBook->rating);
    }

    /** @test */
    public function it_has_ratings_relationship()
    {
        $user = User::factory()->create();
        $rating = $user->ratings()->create([
            'book_id' => Book::factory()->create()->id,
            'rating' => 4,
            'review' => 'Good book',
        ]);
        $this->assertInstanceOf(Rating::class, $user->ratings->first());
        $this->assertEquals('Good book', $rating->review);
    }

    /** @test */
    public function it_has_quotes_relationship()
    {
        $user = User::factory()->create();
        $quote = $user->quotes()->create([
            'book_id' => Book::factory()->create()->id,
            'text' => 'Inspiring quote',
            'page_number' => 123,
            'contains_spoilers' => false,
            'is_public' => true,
        ]);
        $this->assertInstanceOf(Quote::class, $user->quotes->first());
        $this->assertEquals('Inspiring quote', $quote->text);
    }

    /** @test */
    public function it_has_notes_relationship()
    {
        $user = User::factory()->create();
        $note = $user->notes()->create([
            'book_id' => Book::factory()->create()->id,
            'text' => 'Important note',
            'page_number' => 10,
            'contains_spoilers' => false,
            'is_private' => true,
        ]);
        $this->assertInstanceOf(Note::class, $user->notes->first());
        $this->assertEquals('Important note', $note->text);
    }

    /** @test */
    public function it_has_comments_relationship()
    {
        $user = User::factory()->create();
        $comment = $user->comments()->create([
            'commentable_id' => Post::factory()->create()->id,
            'commentable_type' => Post::class,
            'content' => 'Nice post',
        ]);
        $this->assertInstanceOf(Comment::class, $user->comments->first());
        $this->assertEquals('Nice post', $comment->content);
    }

    /** @test */
    public function it_has_likes_relationship()
    {
        $user = User::factory()->create();
        $like = $user->likes()->create([
            'likeable_id' => Post::factory()->create()->id,
            'likeable_type' => Post::class,
        ]);
        $this->assertInstanceOf(Like::class, $user->likes->first());
    }

    /** @test */
    public function it_has_favorites_relationship()
    {
        $user = User::factory()->create();
        $favorite = $user->favorites()->create([
            'favoriteable_id' => Post::factory()->create()->id,
            'favoriteable_type' => Post::class,
        ]);
        $this->assertInstanceOf(Favorite::class, $user->favorites->first());
    }

    /** @test */
    public function it_has_following_and_followers_relationships()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user1->following()->attach($user2->id);
        $this->assertTrue($user1->following->contains($user2));
        $this->assertTrue($user2->followers->contains($user1));
    }

    /** @test */
    public function it_has_view_histories_relationship()
    {
        $user = User::factory()->create();
        $viewHistory = $user->viewHistories()->create([
            'viewable_id' => Post::factory()->create()->id,
            'viewable_type' => Post::class,
        ]);
        $this->assertInstanceOf(ViewHistory::class, $user->viewHistories->first());
    }

    /** @test */
    public function it_has_groups_relationship()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $user->groups()->attach($group->id, ['role' => 'member', 'status' => 'active']);
        $this->assertTrue($user->groups->contains($group));
        $this->assertEquals('member', $user->groups->first()->pivot->role);
        $this->assertEquals('active', $user->groups->first()->pivot->status);
    }

    /** @test */
    public function it_has_group_invitations_relationship()
    {
        $user = User::factory()->create();
        $invitation = $user->groupInvitations()->create([
            'group_id' => Group::factory()->create()->id,
            'invitee_id' => $user->id,
            'inviter_id' => User::factory()->create()->id,
            'status' => InvitationStatus::PENDING,
        ]);
        $this->assertInstanceOf(GroupInvitation::class, $user->groupInvitations->first());
        $this->assertEquals(InvitationStatus::PENDING, $invitation->status);
    }

    /** @test */
    public function it_has_event_rsvps_relationship()
    {
        $user = User::factory()->create();
        $rsvp = $user->eventRsvps()->create([
            'group_event_id' => GroupEvent::factory()->create()->id,
            'response' => EventResponse::GOING,
        ]);
        $this->assertInstanceOf(EventRsvp::class, $user->eventRsvps->first());
        $this->assertEquals(EventResponse::GOING, $rsvp->response);
    }
}
