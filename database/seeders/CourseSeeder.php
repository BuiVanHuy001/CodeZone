<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::factory()->create()->each(function ($course) {
            Module::factory(5)->create()->for($course)->each(function ($module) {
                Lesson::factory(3)->create()->for($module);
            });
        });
    }
}
