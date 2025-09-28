<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Random\RandomException;

class ReviewSeeder extends Seeder
{

    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(string|int $userId, Course $course): void
    {
        Review::create([
            'reviewable_id' => $course->id,
            'reviewable_type' => Course::class,
            'content' => fake()->sentences(random_int(1, 3), true),
            'rating' => random_int(1, 5),
            'user_id' => $userId,
        ]);
    }
}
