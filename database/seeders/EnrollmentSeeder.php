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

        $goodCourses = $courses->random(8);
        $badCourses = $courses->diff($goodCourses)->random(6);

        $reviewSeeder = new ReviewSeeder();

        foreach ($students as $student) {
            $enrolledCourses = $courses->random(random_int(0, 30));

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
                $student->enrollments()->updateOrCreate(
                    ['course_id' => $course->id, 'user_id' => $student->id],
                    ['status' => $status]
                );

                $this->generateProgressTracking($status, $course, $student->id);

                if ($goodCourses->contains($course)) {
                    $rating = random_int(4, 5);
                } elseif ($badCourses->contains($course)) {
                    $rating = random_int(1, 3);
                } else {
                    $rating = random_int(1, 5);
                }

                $isReviewedCourse = fake()->boolean(60);
                if ($isReviewedCourse) {
                    $reviewSeeder->createReview($student->id, $course, $rating);
                }

                $isReviewInstructor = fake()->boolean(40);
                if ($isReviewInstructor) {
                    $instructorRating = random_int(3, 5);
                    $reviewSeeder->createReview($student->id, $course->author, $instructorRating);
                }
            }
        }

        foreach ($courses as $course) {
            $course->update([
                'rating' => round($course->reviews()->avg('rating') ?? 0, 1),
                'enrollment_count' => $course->enrollments()->count(),
                'review_count' => $course->reviews()->count(),
            ]);
        }

        $instructors = User::where('role', 'instructor')->get();
        foreach ($instructors as $instructor) {
            if ($instructor->instructorProfile) {
                $instructor->instructorProfile->update([
                    'rating' => round($instructor->reviews()->avg('rating') ?? 0, 1),
                ]);
            }
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
