<?php

namespace Tests\Unit\Models;

use App\Enums\QuestionStatus;
use App\Models\Author;
use App\Models\AuthorAnswer;
use App\Models\AuthorQuestion;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorQuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $question = AuthorQuestion::factory()->create();

        $this->assertInstanceOf(AuthorQuestion::class, $question);
        $this->assertDatabaseHas('author_questions', [
            'id' => $question->id,
        ]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $question = AuthorQuestion::factory()->create();
        $this->assertInstanceOf(User::class, $question->user);
    }

    /** @test */
    public function it_belongs_to_an_author()
    {
        $question = AuthorQuestion::factory()->create();
        $this->assertInstanceOf(Author::class, $question->author);
    }

    /** @test */
    public function it_belongs_to_a_book()
    {
        $question = AuthorQuestion::factory()->create();
        $this->assertInstanceOf(Book::class, $question->book);
    }

    /** @test */
    public function it_has_many_answers()
    {
        $question = AuthorQuestion::factory()->create();

        AuthorAnswer::factory()->count(3)->create([
            'question_id' => $question->id,
        ]);

        $this->assertCount(3, $question->answers);
        $question->answers->each(function ($answer) {
            $this->assertInstanceOf(AuthorAnswer::class, $answer);
        });
    }

    /** @test */
    public function it_casts_question_status_enum()
    {
        $question = AuthorQuestion::factory()->create([
            'question_status' => QuestionStatus::APPROVED,
        ]);

        $this->assertInstanceOf(QuestionStatus::class, $question->question_status);
        $this->assertEquals(QuestionStatus::APPROVED, $question->question_status);
    }
}
