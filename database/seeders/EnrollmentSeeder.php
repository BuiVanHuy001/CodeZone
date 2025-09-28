<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\TrackingProgress;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        $students = User::where([
            'role' => 'student',
            'status' => 'active',
        ])->get();

        $courses = Course::all();

        foreach ($students as $student) {
            $enrolledCourses = $courses->random(random_int(1, 5));
            $order = Order::create([
                'total_price' => $enrolledCourses->sum('price'),
                'status' => 'completed',
                'payment_method' => fake()->randomElement(Order::$PAYMENT_METHODS),
                'user_id' => $student->id,
            ]);

            foreach ($enrolledCourses as $course) {
                $order->items()->create([
                    'current_price' => $course->price,
                    'course_id' => $course->id,
                ]);
                $status = fake()->randomElement(array_keys(Enrollment::$STATUSES));
                $student->enrollments()->create([
                    'course_id' => $course->id,
                    'status' => $status,
                ]);

                $this->generateProgressTracking($status, $course, $student->id);

                $isReviewed = fake()->boolean;
                if ($isReviewed) {
                    $this->call(
                        class: ReviewSeeder::class,
                        parameters: ['userId' => $student->id, 'course' => $course]
                    );
                }
            }
        }

        foreach ($courses as $course) {
            $course->update([
                'rating' => $course->reviews()->avg('rating') ?? 0,
            ]);
        }
    }

    /**
     * @throws RandomException
     */
    private function generateProgressTracking(string $status, Course $course, string $userId): void
    {
        if ($status === 'in_progress') {
            $lessons = $course->lessons->pluck('id')->toArray();

            shuffle($lessons);
            $completedLessonCount = random_int(1, $course->lesson_count - 1);
            for ($i = 0; $i < $completedLessonCount; $i++) {
                TrackingProgress::create([
                    'is_completed' => true,
                    'user_id' => $userId,
                    'lesson_id' => array_pop($lessons),
                ]);
            }
        }

        if ($status === 'completed') {
            $lessons = $course->lessons();
            foreach ($lessons as $lessonId) {
                TrackingProgress::create([
                    'is_completed' => true,
                    'user_id' => $userId,
                    'lesson_id' => $lessonId,
                ]);
            }
        }
    }
}
