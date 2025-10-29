<?php

namespace Tests\Unit\Models;

use App\Enums\AnswerStatus;
use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use ValueError;

class AuthorAnswerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_properties()
    {
        $model = new AuthorAnswer;

        $this->assertEquals([
            'question_id',
            'author_id',
            'content',
            'published_at',
            'status',
        ], $model->getFillable());
    }

    /** @test */
    public function it_casts_published_at_as_datetime()
    {
        $answer = AuthorAnswer::factory()->create([
            'published_at' => now(),
        ]);

        $this->assertInstanceOf(Carbon::class, $answer->published_at);
    }

    /** @test */
    public function it_casts_answer_status_enum_correctly()
    {
        $answer = AuthorAnswer::factory()->create([
            'status' => AnswerStatus::DRAFT,
        ]);

        $this->assertInstanceOf(AnswerStatus::class, $answer->status);
        $this->assertEquals(AnswerStatus::DRAFT, $answer->status);
    }

    /** @test */
    public function it_belongs_to_question()
    {
        $question = AuthorQuestion::factory()->create();
        $answer = AuthorAnswer::factory()->create([
            'question_id' => $question->id,
        ]);

        $this->assertInstanceOf(AuthorQuestion::class, $answer->question);
        $this->assertEquals($question->id, $answer->question->id);
    }

    /** @test */
    public function it_belongs_to_author()
    {
        $author = Author::factory()->create();
        $answer = AuthorAnswer::factory()->create([
            'author_id' => $author->id,
        ]);

        $this->assertInstanceOf(Author::class, $answer->author);
        $this->assertEquals($author->id, $answer->author->id);
    }

    /** @test */
    public function it_can_be_created_via_factory()
    {
        $answer = AuthorAnswer::factory()->create();

        $this->assertDatabaseHas('author_answers', [
            'id' => $answer->id,
        ]);
    }

    /** @test */
    public function it_rejects_invalid_enum_value_for_answer_status()
    {
        $this->expectException(ValueError::class);

        AuthorAnswer::factory()->create([
            'status' => 'invalid-status',
        ]);
    }
}
