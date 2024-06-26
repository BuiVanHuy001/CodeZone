<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->name;
        $slug = Str::slug($title);
        return [
            'id' => Str::uuid(),
            'title' => $title,
            'slug' => $slug,
            'order' => $this->faker->numberBetween(1, 10),
            'course_id' =>'907bd90b-7e0d-3f56-b7d3-832b4d05dcd8',
        ];
    }
}
