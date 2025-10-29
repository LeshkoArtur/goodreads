<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\Quote;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_comment_can_be_created()
    {
        $comment = Comment::factory()->create();
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    public function test_user_id_is_required_and_must_be_string()
    {
        $data = Comment::factory()->make(['user_id' => null])->toArray();

        $validator = Validator::make($data, ['user_id' => 'required|string|uuid']);
        $this->assertTrue($validator->fails());
    }

    public function test_commentable_type_is_required()
    {
        $data = Comment::factory()->make(['commentable_type' => null])->toArray();

        $validator = Validator::make($data, ['commentable_type' => 'required|string']);
        $this->assertTrue($validator->fails());
    }

    public function test_commentable_id_is_required()
    {
        $data = Comment::factory()->make(['commentable_id' => null])->toArray();

        $validator = Validator::make($data, ['commentable_id' => 'required']);
        $this->assertTrue($validator->fails());
    }

    public function test_content_is_required()
    {
        $data = Comment::factory()->make(['content' => null])->toArray();

        $validator = Validator::make($data, ['content' => 'required|string']);
        $this->assertTrue($validator->fails());
    }

    public function test_parent_id_can_be_null_or_uuid()
    {
        $data = Comment::factory()->make(['parent_id' => null])->toArray();
        $validator = Validator::make($data, ['parent_id' => 'nullable|uuid']);
        $this->assertFalse($validator->fails());

        $data['parent_id'] = 'not-a-uuid';
        $validator = Validator::make($data, ['parent_id' => 'nullable|uuid']);
        $this->assertTrue($validator->fails());
    }

    public function test_user_relationship()
    {
        $comment = Comment::factory()->create();
        $this->assertInstanceOf(User::class, $comment->user);
    }

    public function test_commentable_relationship()
    {
        $models = [
            Post::factory(),
            GroupPost::factory(),
            Quote::factory(),
            Rating::factory(),
        ];

        foreach ($models as $factory) {
            $model = $factory->create();
            $comment = Comment::factory()->create([
                'commentable_type' => get_class($model),
                'commentable_id' => $model->id,
            ]);

            $this->assertInstanceOf(get_class($model), $comment->commentable);
        }
    }

    public function test_replies_relationship()
    {
        $parent = Comment::factory()->create();
        $reply = Comment::factory()->create(['parent_id' => $parent->id]);

        $this->assertTrue($parent->replies->contains($reply));
    }

    public function test_parent_relationship()
    {
        $parent = Comment::factory()->create();
        $reply = Comment::factory()->create(['parent_id' => $parent->id]);

        $this->assertEquals($parent->id, $reply->parent->id);
    }
}
