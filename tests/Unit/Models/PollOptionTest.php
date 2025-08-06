<?php

namespace Tests\Unit\Models;

use App\Models\GroupPoll;
use App\Models\PollOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PollOptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_created_with_factory()
    {
        $option = PollOption::factory()->create();

        $this->assertDatabaseHas('poll_options', [
            'id' => $option->id,
            'text' => $option->text,
        ]);
    }

    /** @test */
    public function it_has_uuid_as_primary_key()
    {
        $option = PollOption::factory()->create();

        $this->assertTrue(Str::isUuid($option->id));
    }

    /** @test */
    public function it_has_fillable_fields()
    {
        $poll = GroupPoll::factory()->create();

        $data = [
            'group_poll_id' => $poll->id,
            'text' => 'Option text',
            'vote_count' => 10,
        ];

        $option = PollOption::create($data);

        $this->assertEquals($data['group_poll_id'], $option->group_poll_id);
        $this->assertEquals($data['text'], $option->text);
        $this->assertEquals($data['vote_count'], $option->vote_count);
    }

    /** @test */
    public function it_belongs_to_a_poll()
    {
        $poll = GroupPoll::factory()->create();
        $option = PollOption::factory()->create(['group_poll_id' => $poll->id]);

        $this->assertInstanceOf(GroupPoll::class, $option->poll);
        $this->assertTrue($poll->is($option->poll));
    }

    /** @test */
    public function it_can_be_updated()
    {
        $option = PollOption::factory()->create();

        $option->update([
            'text' => 'Updated text',
            'vote_count' => 99,
        ]);

        $this->assertDatabaseHas('poll_options', [
            'id' => $option->id,
            'text' => 'Updated text',
            'vote_count' => 99,
        ]);
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $option = PollOption::factory()->create();
        $id = $option->id;

        $option->delete();

        $this->assertDatabaseMissing('poll_options', [
            'id' => $id,
        ]);
    }

    /** @test */
    public function it_can_handle_multiple_options_for_poll()
    {
        $poll = GroupPoll::factory()->create();

        $options = PollOption::factory()->count(3)->create([
            'group_poll_id' => $poll->id,
        ]);

        $this->assertCount(3, $poll->options);
        $this->assertInstanceOf(PollOption::class, $poll->options->first());
    }
}
