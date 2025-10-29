<?php

namespace Tests\Unit\Models;

use App\Models\Group;
use App\Models\GroupPoll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GroupPollTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_creates_valid_group_poll()
    {
        $poll = GroupPoll::factory()->create();

        $this->assertDatabaseHas('group_polls', [
            'id' => $poll->id,
            'question' => $poll->question,
        ]);
    }

    public function test_required_fields_validation_fails()
    {
        $data = [];

        $validator = Validator::make($data, [
            'group_id' => 'required|uuid|exists:groups,id',
            'creator_id' => 'required|uuid|exists:users,id',
            'question' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('group_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('creator_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('question', $validator->errors()->toArray());
        $this->assertArrayHasKey('is_active', $validator->errors()->toArray());
    }

    public function test_question_must_not_exceed_max_length()
    {
        $data = GroupPoll::factory()->make(['question' => str_repeat('a', 256)])->toArray();

        $validator = Validator::make($data, [
            'question' => 'required|string|max:255',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('question', $validator->errors()->toArray());
    }

    public function test_group_relationship()
    {
        $group = Group::factory()->create();
        $poll = GroupPoll::factory()->create(['group_id' => $group->id]);

        $this->assertTrue($poll->group->is($group));
    }

    public function test_creator_relationship()
    {
        $user = User::factory()->create();
        $poll = GroupPoll::factory()->create(['creator_id' => $user->id]);

        $this->assertTrue($poll->creator->is($user));
    }

    public function test_options_relationship()
    {
        $poll = GroupPoll::factory()->create();
        $poll->options()->createMany([
            ['text' => 'Option 1'],
            ['text' => 'Option 2'],
        ]);

        $this->assertCount(2, $poll->options);
        $this->assertInstanceOf(PollOption::class, $poll->options->first());
    }

    public function test_votes_relationship()
    {
        $poll = GroupPoll::factory()->create();

        $options = $poll->options()->createMany([
            ['text' => 'Option 1'],
            ['text' => 'Option 2'],
        ]);

        $poll->votes()->createMany([
            [
                'user_id' => User::factory()->create()->id,
                'poll_option_id' => $options[0]->id,
            ],
            [
                'user_id' => User::factory()->create()->id,
                'poll_option_id' => $options[1]->id,
            ],
        ]);

        $this->assertCount(2, $poll->votes);
        $this->assertInstanceOf(PollVote::class, $poll->votes->first());
    }
}
