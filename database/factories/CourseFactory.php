<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Random\RandomException;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 100_000, 1_000_000),
            'level' => fake()->randomElement(array_keys(Course::$LEVELS)),
            'category_id' => fake()->randomElement(DB::table('categories')->pluck('id')->toArray()),
            'review_count' => 0,
            'lesson_count' => 0,
            'duration' => random_int(10 * 3600, 25 * 3600),
            'created_at' => fake()->dateTimeBetween('-1 year')
        ];
    }
}
