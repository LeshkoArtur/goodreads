<?php

namespace Tests\Unit\Models;

use App\Enums\EventResponse;
use App\Models\EventRsvp;
use App\Models\GroupEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class EventRsvpTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_rsvp_can_be_created()
    {
        $rsvp = EventRsvp::factory()->create();

        $this->assertDatabaseHas('event_rsvps', [
            'id' => $rsvp->id,
        ]);
        $this->assertInstanceOf(EventResponse::class, $rsvp->response);
    }

    public function test_event_rsvp_has_event_relationship()
    {
        $rsvp = EventRsvp::factory()->create();

        $this->assertInstanceOf(GroupEvent::class, $rsvp->event);
    }

    public function test_event_rsvp_has_user_relationship()
    {
        $rsvp = EventRsvp::factory()->create();

        $this->assertInstanceOf(User::class, $rsvp->user);
    }

    public function test_event_response_must_be_valid_enum_case()
    {
        $data = EventRsvp::factory()->make(['event_response' => 'INVALID'])->toArray();

        $validator = Validator::make($data, [
            'event_response' => 'in:' . implode(',', array_map(fn($case) => $case->value, EventResponse::cases())),
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('event_response', $validator->errors()->toArray());
    }

    public function test_event_response_accepts_valid_enum_values()
    {
        foreach (EventResponse::cases() as $case) {
            $data = EventRsvp::factory()->make(['event_response' => $case->value])->toArray();

            $validator = Validator::make($data, [
                'event_response' => 'in:' . implode(',', array_map(fn($c) => $c->value, EventResponse::cases())),
            ]);

            $this->assertFalse($validator->fails(), "Failed asserting enum case '{$case->value}' is valid.");
        }
    }
}
