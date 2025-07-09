<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(5);
        $slug = str($name)->slug();
        return [
            'id' => fake()->uuid(),
            'title' => $name,
            'slug' => $slug,
            'heading' => fake()->sentence(15),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 100_000, 1_000_000),
            'level' => fake()->randomElement(Course::$LEVELS),
            'status' => fake()->randomElement(Course::$STATUSES),
            'category_id' => fake()->randomElement(\Illuminate\Support\Facades\DB::table('categories')->pluck('id')->toArray()),
            'review_count' => 0,
            'lesson_count' => 0,
            'duration' => 24434,
        ];
    }
}
