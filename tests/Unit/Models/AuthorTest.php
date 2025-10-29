<?php

namespace Tests\Unit\Models;

use App\Enums\TypeOfWork;
use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use App\Models\Book;
use App\Models\NominationEntry;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_fields()
    {
        $author = new Author;
        $this->assertEquals([
            'name',
            'bio',
            'birth_date',
            'birth_place',
            'nationality',
            'website',
            'profile_picture',
            'death_date',
            'social_media_links',
            'media_images',
            'media_videos',
            'fun_facts',
            'type_of_work',
        ], $author->getFillable());
    }

    /** @test */
    public function it_casts_fields_correctly()
    {
        $author = Author::factory()->create();

        $this->assertInstanceOf(Carbon::class, $author->birth_date);
        if ($author->death_date !== null) {
            $this->assertInstanceOf(Carbon::class, $author->death_date);
        }

        $this->assertInstanceOf(TypeOfWork::class, $author->type_of_work);
        $this->assertInstanceOf(Collection::class, $author->social_media_links);
        $this->assertInstanceOf(Collection::class, $author->media_images);
        $this->assertInstanceOf(Collection::class, $author->media_videos);
        $this->assertInstanceOf(Collection::class, $author->fun_facts);
    }

    /** @test */
    public function it_can_be_created_via_factory()
    {
        $author = Author::factory()->create();

        $this->assertDatabaseHas('authors', ['id' => $author->id]);
        $this->assertNotNull($author->name);
    }

    /** @test */
    public function it_can_be_created_via_mass_assignment()
    {
        $data = [
            'name' => 'John Doe',
            'bio' => 'Author bio here.',
            'birth_date' => '1980-01-01',
            'birth_place' => 'Tokyo',
            'nationality' => 'Japan',
            'website' => 'https://example.com',
            'profile_picture' => 'https://example.com/img.jpg',
            'death_date' => null,
            'social_media_links' => collect(['twitter' => 'https://twitter.com/john']),
            'media_images' => collect(['img1.jpg']),
            'media_videos' => collect(['vid1.mp4']),
            'fun_facts' => collect(['Loves sushi']),
            'type_of_work' => TypeOfWork::ESSAYIST,
        ];

        $author = Author::create($data);

        $this->assertDatabaseHas('authors', ['id' => $author->id]);
        $this->assertEquals('John Doe', $author->name);
        $this->assertInstanceOf(TypeOfWork::class, $author->type_of_work);
    }

    /** @test */
    public function it_generates_uuid_as_id()
    {
        $author = Author::factory()->create();
        $this->assertTrue(Str::isUuid($author->id));
    }

    /** @test */
    public function it_handles_enum_casting_correctly()
    {
        $author = Author::factory()->create(['type_of_work' => TypeOfWork::ESSAYIST]);
        $this->assertEquals(TypeOfWork::ESSAYIST, $author->type_of_work);
    }

    /** @test */
    public function it_allows_nullable_death_date()
    {
        $author = Author::factory()->create(['death_date' => null]);
        $this->assertNull($author->death_date);
    }

    /** @test */
    public function it_belongs_to_many_users()
    {
        $author = Author::factory()->create();
        $user = User::factory()->create();
        $author->users()->attach($user);

        $this->assertTrue($author->users->contains($user));
    }

    /** @test */
    public function it_belongs_to_many_books()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create();
        $author->books()->attach($book);

        $this->assertTrue($author->books->contains($book));
    }

    /** @test */
    public function it_has_many_nominations()
    {
        $author = Author::factory()->create();
        $nom = NominationEntry::factory()->create(['author_id' => $author->id]);

        $this->assertTrue($author->nominations->contains($nom));
    }

    /** @test */
    public function it_has_many_questions()
    {
        $author = Author::factory()->create();
        $question = AuthorQuestion::factory()->create(['author_id' => $author->id]);

        $this->assertTrue($author->questions->contains($question));
    }

    /** @test */
    public function it_has_many_answers()
    {
        $author = Author::factory()->create();
        $answer = AuthorAnswer::factory()->create(['author_id' => $author->id]);

        $this->assertTrue($author->answers->contains($answer));
    }

    /** @test */
    public function it_has_many_posts()
    {
        $author = Author::factory()->create();
        $post = Post::factory()->create(['author_id' => $author->id]);

        $this->assertTrue($author->posts->contains($post));
    }

    /** @test */
    public function it_returns_correct_collection_data()
    {
        $author = Author::factory()->create([
            'social_media_links' => collect(['x' => 'url']),
            'media_images' => collect(['img1']),
            'media_videos' => collect(['vid1']),
            'fun_facts' => collect(['fact1']),
        ]);

        $this->assertEquals('url', $author->social_media_links->get('x'));
        $this->assertContains('img1', $author->media_images);
        $this->assertContains('vid1', $author->media_videos);
        $this->assertContains('fact1', $author->fun_facts);
    }
}
