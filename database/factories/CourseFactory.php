<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Random\RandomException;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'title' => fake()->unique()->sentence(random_int(5, 10)),
            'heading' => fake()->sentence(random_int(15, 20)),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 100_000, 1_000_000),
            'level' => fake()->randomElement(Course::$LEVELS),
            'status' => fake()->randomElement(Course::$STATUSES),
            'category_id' => fake()->randomElement(DB::table('categories')->pluck('id')->toArray()),
            'review_count' => 0,
            'lesson_count' => 0,
            'duration' => random_int(10 * 3600, 25 * 3600),
        ];
    }
}
