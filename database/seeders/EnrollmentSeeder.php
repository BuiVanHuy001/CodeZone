<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\TrackingProgress;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;
use Spatie\Permission\Models\Role;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws RandomException
     */
    public function run(): void
    {
        $students = Role::findByName('student')->users()->where(['status' => 'active'])->get();

        $courses = Course::whereNotIn('status', ['rejected', 'draft', 'pending'])->get();

        $goodCourses = $courses->random(10);
        $badCourses = $courses->diff($goodCourses)->random(6);

        $reviewSeeder = new ReviewSeeder();

        foreach ($students as $student) {
            $enrolledCourses = $courses->random(random_int(0, 30))->unique('id');

            $student->studentProfile()->updateOrCreate(
                ['user_id' => $student->id],
                ['enrolled_count' => $enrolledCourses->count()]
            );

            $orderCreatedAt = fake()->dateTimeBetween('-1 year', 'now');
            $orderUpdatedAt = fake()->dateTimeBetween($orderCreatedAt, 'now');

            $order = Order::create([
                'total_price' => $enrolledCourses->sum('price'),
                'status' => 'completed',
                'payment_method' => fake()->randomElement(Order::$PAYMENT_METHODS),
                'user_id' => $student->id,
                'created_at' => $orderCreatedAt,
                'updated_at' => $orderUpdatedAt,
            ]);

            foreach ($enrolledCourses as $course) {
                $order->items()->create([
                    'current_price' => $course->price,
                    'course_id' => $course->id,
                    'created_at' => $orderCreatedAt,
                    'updated_at' => $orderUpdatedAt,
                ]);
                $status = fake()->randomElement(array_keys(Enrollment::$STATUSES));
                if ($status === 'completed') {
                    $student->load('studentProfile');
                    if ($student->studentProfile) {
                        $student->studentProfile->update([
                            'completed_count' => $student->studentProfile->completed_count + 1
                        ]);
                    }
                }

                Enrollment::updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'status' => $status,
                    ]
                );

                $this->generateProgressTracking($status, $course, $student->id);

                if ($goodCourses->contains($course)) {
                    $rating = random_int(3, 5);
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
                    $instructorRating = random_int(1, 5);
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

        $instructors = Role::findByName('instructor')->users()->get();
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
        $lessons = $course->lessons->pluck('id')->toArray();

        if ($status === 'in_progress') {
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
