<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'reportable_id' => fake()->uuid(),
            'reportable_type' => fake()->randomElement([
                'Post', 'Comment', 'Quote'
            ]),
            'report_type' => fake()->randomElement(['spam', 'offensive', 'inappropriate', 'spoilers', 'copyright', 'other']),
            'description' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['pending', 'reviewed', 'resolved', 'dismissed'])
        ];
    }
}
