<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws Throwable
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $sql = file_get_contents(database_path('codezone.sql'));
            \DB::unprepared($sql);
            $this->call(UserSeeder::class);
            $this->call(CourseSeeder::class);
            $this->call(EnrollmentSeeder::class);
            $this->call(CommentSeeder::class);
            $this->call(ReactionSeeder::class);

            $instructors = User::where('role', 'instructor')->get();
            foreach ($instructors as $instructor) {
                $instructorProfile = $instructor->instructorProfile;

                if ($instructorProfile) {
                    $instructorProfile->student_count = $instructor->courses->sum('enrollment_count');
                    $instructorProfile->course_count = $instructor->courses->where('status', 'published')->count();
                    $instructorProfile->review_count = $instructor->reviews->count();
                    $instructorProfile->rating = $instructor->reviews->avg('rating') ?? 0;
                    $instructorProfile->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
