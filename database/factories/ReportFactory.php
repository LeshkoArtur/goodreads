<?php

namespace Database\Factories;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Comment;
use App\Models\GroupPost;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        $reportableTypes = [
            Post::class => Post::factory(),
            GroupPost::class => GroupPost::factory(),
            Comment::class => Comment::factory(),
        ];

        $reportableType = $this->faker->randomElement(array_keys($reportableTypes));
        $reportableFactory = $reportableTypes[$reportableType];

        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(ReportType::cases()),
            'reportable_type' => $reportableType,
            'reportable_id' => $reportableFactory,
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(ReportStatus::cases()),
        ];
    }
}
