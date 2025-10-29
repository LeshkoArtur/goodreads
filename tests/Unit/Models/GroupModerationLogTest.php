<?php

namespace Tests\Unit\Models;

use App\Models\Group;
use App\Models\GroupModerationLog;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupModerationLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_valid_data()
    {
        $group = Group::factory()->create();
        $moderator = User::factory()->create();
        $target = Post::factory()->create();

        $log = GroupModerationLog::create([
            'group_id' => $group->id,
            'moderator_id' => $moderator->id,
            'action' => 'delete_post',
            'targetable_id' => $target->id,
            'targetable_type' => get_class($target),
            'description' => 'Deleted spam post',
        ]);

        $this->assertDatabaseHas('group_moderation_logs', [
            'id' => $log->id,
            'action' => 'delete_post',
            'description' => 'Deleted spam post',
        ]);
    }

    /** @test */
    public function it_has_expected_fillable_attributes()
    {
        $log = new GroupModerationLog;

        $this->assertEquals([
            'group_id',
            'moderator_id',
            'action',
            'targetable_id',
            'targetable_type',
            'description',
        ], $log->getFillable());
    }

    /** @test */
    public function it_belongs_to_a_group()
    {
        $log = GroupModerationLog::factory()->for(Group::factory())->create();

        $this->assertInstanceOf(Group::class, $log->group);
    }

    /** @test */
    public function it_belongs_to_a_moderator()
    {
        $log = GroupModerationLog::factory()->for(User::factory(), 'moderator')->create();

        $this->assertInstanceOf(User::class, $log->moderator);
    }

    /** @test */
    public function it_morphs_to_a_targetable_model()
    {
        $post = Post::factory()->create();

        $log = GroupModerationLog::create([
            'group_id' => Group::factory()->create()->id,
            'moderator_id' => User::factory()->create()->id,
            'action' => 'delete_post',
            'targetable_id' => $post->id,
            'targetable_type' => get_class($post),
            'description' => 'Deleted inappropriate content',
        ]);

        $this->assertInstanceOf(Post::class, $log->targetable);
        $this->assertEquals($post->id, $log->targetable->id);
    }
}
