<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\User;
use App\Models\ViewHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewHistoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_expected_fillable_fields()
    {
        $model = new ViewHistory();

        $this->assertEquals([
            'user_id',
            'viewable_id',
            'viewable_type',
        ], $model->getFillable());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $viewHistory = ViewHistory::factory()->create();

        $this->assertInstanceOf(User::class, $viewHistory->user);
        $this->assertTrue($viewHistory->user->is(User::find($viewHistory->user_id)));
    }

    /** @test */
    public function it_morphs_to_a_book()
    {
        $book = Book::factory()->create();
        $history = ViewHistory::create([
            'user_id' => User::factory()->create()->id,
            'viewable_type' => Book::class,
            'viewable_id' => $book->id,
        ]);

        $this->assertInstanceOf(Book::class, $history->viewable);
        $this->assertTrue($history->viewable->is($book));
    }

    /** @test */
    public function it_morphs_to_a_post()
    {
        $post = Post::factory()->create();
        $history = ViewHistory::create([
            'user_id' => User::factory()->create()->id,
            'viewable_type' => Post::class,
            'viewable_id' => $post->id,
        ]);

        $this->assertInstanceOf(Post::class, $history->viewable);
        $this->assertTrue($history->viewable->is($post));
    }

    /** @test */
    public function it_morphs_to_a_group_post()
    {
        $groupPost = GroupPost::factory()->create();
        $history = ViewHistory::create([
            'user_id' => User::factory()->create()->id,
            'viewable_type' => GroupPost::class,
            'viewable_id' => $groupPost->id,
        ]);

        $this->assertInstanceOf(GroupPost::class, $history->viewable);
        $this->assertTrue($history->viewable->is($groupPost));
    }

    /** @test */
    public function it_uses_uuids_as_ids()
    {
        $viewHistory = ViewHistory::factory()->create();

        $this->assertIsString($viewHistory->id);
        $this->assertMatchesRegularExpression('/^[\w-]{36}$/', $viewHistory->id);
    }
}
