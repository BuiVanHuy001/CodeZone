<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Dislike;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Like;
use App\Models\Order;
use App\Models\Review;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//       User::factory(30)->create();
//        Student::factory(30)->create();
//       Instructor::factory(10)->create();
//        CourseCategory::factory(5)->create();
        Course::factory(1)->create();
        Subject::factory(10)->create();
        Lesson::factory(39)->create();
    //    Like::factory(10)->create();
    //    Dislike::factory(5)->create();
//        Comment::factory(500)->create();
//        Review::factory(500)->create();
//        Order::factory(500)->create();
//        Enrollment::factory(1000)->create();
    }
}
