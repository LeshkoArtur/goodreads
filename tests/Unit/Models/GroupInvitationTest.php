<?php

namespace Tests\Unit\Models;

use App\Enums\InvitationStatus;
use App\Models\Group;
use App\Models\GroupInvitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tests\TestCase;

class GroupInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_group_invitation_belongs_to_group()
    {
        $invitation = GroupInvitation::factory()->create();
        $this->assertInstanceOf(Group::class, $invitation->group);
    }

    public function test_group_invitation_belongs_to_inviter()
    {
        $invitation = GroupInvitation::factory()->create();
        $this->assertInstanceOf(User::class, $invitation->inviter);
    }

    public function test_group_invitation_belongs_to_invitee()
    {
        $invitation = GroupInvitation::factory()->create();
        $this->assertInstanceOf(User::class, $invitation->invitee);
    }

    public function test_status_casts_to_enum()
    {
        $invitation = GroupInvitation::factory()->create([
            'status' => InvitationStatus::PENDING,
        ]);

        $this->assertInstanceOf(InvitationStatus::class, $invitation->status);
        $this->assertEquals(InvitationStatus::PENDING, $invitation->status);
    }

    public function test_invalid_status_fails_validation()
    {
        $data = GroupInvitation::factory()->make()->toArray();
        $data['status'] = 'not_a_status';

        $validator = Validator::make($data, [
            'status' => ['required', Rule::in(array_map(fn ($e) => $e->value, InvitationStatus::cases()))],
        ]);

        $this->assertTrue($validator->fails(), 'Validation should fail for invalid enum value.');
        $this->assertArrayHasKey('status', $validator->errors()->toArray(), 'Validation error should exist for status.');
    }

    public function test_valid_status_passes_validation()
    {
        $status = InvitationStatus::ACCEPTED->value;

        $data = GroupInvitation::factory()->make(['status' => $status])->toArray();

        $validator = Validator::make($data, [
            'status' => 'required|in:'.implode(',', array_map(fn ($e) => $e->value, InvitationStatus::cases())),
        ]);

        $this->assertFalse($validator->fails());
    }

    public function test_uuid_fields_are_strings()
    {
        $invitation = GroupInvitation::factory()->create();

        $this->assertIsString($invitation->group_id);
        $this->assertIsString($invitation->inviter_id);
        $this->assertIsString($invitation->invitee_id);
    }

    public function test_created_at_and_updated_at_are_casted_to_datetime()
    {
        $invitation = GroupInvitation::factory()->create();

        $this->assertNotNull($invitation->created_at);
        $this->assertNotNull($invitation->updated_at);
        $this->assertInstanceOf(Carbon::class, $invitation->created_at);
        $this->assertInstanceOf(Carbon::class, $invitation->updated_at);
    }
}
