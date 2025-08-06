<?php

namespace Tests\Unit\Models;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\GroupInvitation;
use App\Models\GroupModerationLog;
use App\Models\GroupPoll;
use App\Models\GroupPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $group = Group::factory()->create();

        $this->assertInstanceOf(Group::class, $group);
        $this->assertIsBool($group->is_public);
        $this->assertIsInt($group->member_count);
        $this->assertIsBool($group->is_active);
        $this->assertInstanceOf(JoinPolicy::class, $group->join_policy);
        $this->assertInstanceOf(PostPolicy::class, $group->post_policy);
    }

    /** @test */
    public function is_public_must_be_boolean()
    {
        $data = Group::factory()->make()->toArray();
        $data['is_public'] = 'not-boolean';

        $validator = Validator::make($data, [
            'is_public' => 'boolean',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('is_public', $validator->errors()->toArray());
    }

    /** @test */
    public function it_belongs_to_creator()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create(['creator_id' => $user->id]);

        $this->assertInstanceOf(User::class, $group->creator);
        $this->assertTrue($group->creator->is($user));
    }

    /** @test */
    public function it_has_many_members()
    {
        $group = Group::factory()->create();
        $users = User::factory(3)->create();

        $group->members()->attach($users->pluck('id'), [
            'role' => 'member',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        $this->assertCount(3, $group->members);
    }

    /** @test */
    public function it_has_many_posts()
    {
        $group = Group::factory()->create();
        GroupPost::factory()->count(5)->create(['group_id' => $group->id]);

        $this->assertCount(5, $group->posts);
        $this->assertInstanceOf(GroupPost::class, $group->posts->first());
    }

    /** @test */
    public function it_has_many_events()
    {
        $group = Group::factory()->create();
        GroupEvent::factory()->count(2)->create(['group_id' => $group->id]);

        $this->assertCount(2, $group->events);
        $this->assertInstanceOf(GroupEvent::class, $group->events->first());
    }

    /** @test */
    public function it_has_many_invitations()
    {
        $group = Group::factory()->create();
        GroupInvitation::factory()->count(4)->create(['group_id' => $group->id]);

        $this->assertCount(4, $group->invitations);
        $this->assertInstanceOf(GroupInvitation::class, $group->invitations->first());
    }

    /** @test */
    public function it_has_many_polls()
    {
        $group = Group::factory()->create();
        GroupPoll::factory()->count(3)->create(['group_id' => $group->id]);

        $this->assertCount(3, $group->polls);
        $this->assertInstanceOf(GroupPoll::class, $group->polls->first());
    }

    /** @test */
    public function it_has_many_moderation_logs()
    {
        $group = Group::factory()->create();
        GroupModerationLog::factory()->count(2)->create(['group_id' => $group->id]);

        $this->assertCount(2, $group->moderationLogs);
        $this->assertInstanceOf(GroupModerationLog::class, $group->moderationLogs->first());
    }

    /** @test */
    public function casts_are_set_correctly()
    {
        $group = Group::factory()->create();

        $this->assertIsBool($group->is_public);
        $this->assertIsBool($group->is_active);
        $this->assertIsInt($group->member_count);
        $this->assertInstanceOf(JoinPolicy::class, $group->join_policy);
        $this->assertInstanceOf(PostPolicy::class, $group->post_policy);
    }
}
