<?php

namespace Tests\Unit\Models;

use App\Enums\EventStatus;
use App\Models\Group;
use App\Models\GroupEvent;
use App\Models\User;
use App\Models\EventRsvp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GroupEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_required_fields_validation()
    {
        $data = [];

        $validator = Validator::make($data, [
            'group_id' => 'required|uuid',
            'creator_id' => 'required|uuid',
            'title' => 'required|string',
            'event_date' => 'required|date',
            'group_status' => 'required',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('group_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('creator_id', $validator->errors()->toArray());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
        $this->assertArrayHasKey('event_date', $validator->errors()->toArray());
        $this->assertArrayHasKey('group_status', $validator->errors()->toArray());
    }

    public function test_event_date_must_be_datetime()
    {
        $data = GroupEvent::factory()->make()->toArray();
        $data['event_date'] = 'not-a-date';

        $validator = Validator::make($data, [
            'event_date' => 'required|date',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('event_date', $validator->errors()->toArray());
    }

    public function test_group_status_must_be_enum_value()
    {
        $data = GroupEvent::factory()->make()->toArray();
        $data['group_status'] = 'invalid_status';

        $validator = Validator::make($data, [
            'group_status' => 'required|in:' . implode(',', array_map(fn($e) => $e->value, EventStatus::cases())),
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('group_status', $validator->errors()->toArray());
    }

    public function test_title_and_description_must_be_string()
    {
        $data = GroupEvent::factory()->make([
            'title' => 123,
            'description' => 456,
        ])->toArray();

        $validator = Validator::make($data, [
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('title', $validator->errors()->toArray());
        $this->assertArrayHasKey('description', $validator->errors()->toArray());
    }

    public function test_group_event_belongs_to_group()
    {
        $groupEvent = GroupEvent::factory()->create();

        $this->assertInstanceOf(Group::class, $groupEvent->group);
    }

    public function test_group_event_belongs_to_creator()
    {
        $groupEvent = GroupEvent::factory()->create();

        $this->assertInstanceOf(User::class, $groupEvent->creator);
    }

    public function test_group_event_has_many_rsvps()
    {
        $groupEvent = GroupEvent::factory()->create();
        EventRsvp::factory()->count(3)->create(['group_event_id' => $groupEvent->id]);

        $this->assertCount(3, $groupEvent->rsvps);
        $this->assertInstanceOf(EventRsvp::class, $groupEvent->rsvps->first());
    }

    public function test_casting_event_date_to_datetime()
    {
        $groupEvent = GroupEvent::factory()->create([
            'event_date' => now(),
        ]);

        $this->assertInstanceOf(Carbon::class, $groupEvent->event_date);
    }

    public function test_casting_group_status_to_enum()
    {
        $groupEvent = GroupEvent::factory()->create([
            'status' => EventStatus::UPCOMING,
        ]);

        $this->assertInstanceOf(EventStatus::class, $groupEvent->status);
        $this->assertEquals(EventStatus::UPCOMING, $groupEvent->status);
    }
}
