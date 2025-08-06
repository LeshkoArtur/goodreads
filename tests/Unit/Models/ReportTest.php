<?php

namespace Tests\Unit\Models;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_report_with_valid_data()
    {
        $report = Report::factory()->create();

        $this->assertInstanceOf(Report::class, $report);
        $this->assertDatabaseHas('reports', [
            'id' => $report->id,
        ]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $report = Report::factory()->create();

        $this->assertInstanceOf(User::class, $report->user);
    }

    /** @test */
    public function it_has_a_polymorphic_reportable_relation()
    {
        $types = [
            Post::class,
            GroupPost::class,
            Comment::class,
        ];

        foreach ($types as $type) {
            $reportable = $type::factory()->create();
            $report = Report::factory()->create([
                'reportable_type' => $type,
                'reportable_id' => $reportable->id,
            ]);

            $this->assertInstanceOf($type, $report->reportable);
        }
    }

    /** @test */
    public function it_casts_enum_attributes_correctly()
    {
        $report = Report::factory()->create();

        $this->assertInstanceOf(ReportType::class, $report->type);
        $this->assertInstanceOf(ReportStatus::class, $report->status);
    }
}
