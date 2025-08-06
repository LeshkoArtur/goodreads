<?php

namespace Tests\Unit\Models;

use App\Models\GroupPoll;
use App\Models\PollOption;
use App\Models\PollVote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PollVoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_poll_vote_can_be_created_with_valid_data(): void
    {
        $vote = PollVote::factory()->create();

        $this->assertDatabaseHas('poll_votes', [
            'id' => $vote->id,
            'group_poll_id' => $vote->group_poll_id,
            'poll_option_id' => $vote->poll_option_id,
            'user_id' => $vote->user_id,
        ]);
    }

    public function test_poll_vote_validation_fails_with_missing_fields(): void
    {
        $data = [];

        $validator = Validator::make($data, [
            'group_poll_id' => 'required|exists:group_polls,id',
            'poll_option_id' => 'required|exists:poll_options,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('group_poll_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('poll_option_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('user_id', $validator->errors()->toArray());
    }

    public function test_poll_vote_validation_fails_with_invalid_ids(): void
    {
        $data = [
            'group_poll_id' => 'aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa',
            'poll_option_id' => 'bbbbbbbb-bbbb-bbbb-bbbb-bbbbbbbbbbbb',
            'user_id' => 'cccccccc-cccc-cccc-cccc-cccccccccccc',
        ];

        $validator = Validator::make($data, [
            'group_poll_id' => 'required|exists:group_polls,id',
            'poll_option_id' => 'required|exists:poll_options,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('group_poll_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('poll_option_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('user_id', $validator->errors()->toArray());
    }


    public function test_poll_vote_belongs_to_poll(): void
    {
        $vote = PollVote::factory()->create();

        $this->assertInstanceOf(GroupPoll::class, $vote->poll);
        $this->assertEquals($vote->group_poll_id, $vote->poll->id);
    }

    public function test_poll_vote_belongs_to_option(): void
    {
        $vote = PollVote::factory()->create();

        $this->assertInstanceOf(PollOption::class, $vote->option);
        $this->assertEquals($vote->poll_option_id, $vote->option->id);
    }

    public function test_poll_vote_belongs_to_user(): void
    {
        $vote = PollVote::factory()->create();

        $this->assertInstanceOf(User::class, $vote->user);
        $this->assertEquals($vote->user_id, $vote->user->id);
    }
}
