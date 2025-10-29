<?php

namespace Tests\Unit\Models;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Group;
use App\Models\GroupModerationLog;
use App\Models\GroupPost;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GroupPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_group_relationship()
    {
        $post = GroupPost::factory()->create();
        $this->assertInstanceOf(Group::class, $post->group);
    }

    public function test_user_relationship()
    {
        $post = GroupPost::factory()->create();
        $this->assertInstanceOf(User::class, $post->user);
    }

    public function test_comments_relationship()
    {
        $post = GroupPost::factory()->create();

        $post->comments()->create([
            'user_id' => User::factory()->create()->id,
            'content' => 'Test comment',
        ]);

        $this->assertCount(1, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments->first());
    }

    public function test_likes_relationship()
    {
        $post = GroupPost::factory()->create();

        $post->likes()->create([
            'user_id' => User::factory()->create()->id,
        ]);

        $this->assertCount(1, $post->likes);
        $this->assertInstanceOf(Like::class, $post->likes->first());
    }

    public function test_favorites_relationship()
    {
        $post = GroupPost::factory()->create();

        $post->favorites()->create([
            'user_id' => User::factory()->create()->id,
        ]);

        $this->assertCount(1, $post->favorites);
        $this->assertInstanceOf(Favorite::class, $post->favorites->first());
    }

    public function test_moderation_logs_relationship()
    {
        $post = GroupPost::factory()->create();

        $post->moderationLogs()->create([
            'group_id' => $post->group_id,
            'moderator_id' => User::factory()->create()->id,
            'action' => 'edit',
            'description' => 'Edited post content',
        ]);

        $this->assertCount(1, $post->moderationLogs);
        $this->assertInstanceOf(GroupModerationLog::class, $post->moderationLogs->first());
    }

    public function test_category_must_be_valid_enum_value()
    {
        $data = GroupPost::factory()->make()->toArray();
        $data['category'] = 'invalid';

        $validator = Validator::make($data, [
            'category' => 'required|in:'.implode(',', array_map(fn ($c) => $c->value, PostCategory::cases())),
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('category', $validator->errors()->toArray());
    }

    public function test_post_status_must_be_valid_enum_value()
    {
        $data = GroupPost::factory()->make()->toArray();
        $data['post_status'] = 'invalid';

        $validator = Validator::make($data, [
            'post_status' => 'required|in:'.implode(',', array_map(fn ($s) => $s->value, PostStatus::cases())),
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('post_status', $validator->errors()->toArray());
    }

    public function test_is_pinned_must_be_boolean()
    {
        $data = GroupPost::factory()->make()->toArray();
        $data['is_pinned'] = 'not-a-boolean';

        $validator = Validator::make($data, [
            'is_pinned' => 'required|boolean',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('is_pinned', $validator->errors()->toArray());
    }
}
