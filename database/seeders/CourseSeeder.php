<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Random\RandomException;
use Throwable;

class CourseSeeder extends Seeder
{
    public array $videoFileNames = [
        '3PvrlYX3DVnHQ11q84rOD6hShddMT2-metaUHl0aG9uIFN0YWNrcyAtIFB5dGhvbiBUdXRvcmlhbCBmb3IgQWJzb2x1dGUgQmVnaW5uZXJzIC0gTW9zaCAtIFlvdVR1YmUubXA0-.mp4',
        '7sPOPfpibvEJyIi17SpvHFZ9wDOYAy-metaIzQgQlVJTEQgJiBDSEHMo1kgSU1BR0UgVcybzIFORyBEVcyjTkcgTk9ERS5KUyBWT8ybzIFJIERPQ0tFUiAtIERvY2tlciBTaWXMgnUgRGXMgsyDIENobyBCZWdpbm5lcnMgVHXMm8yAIEEgxJFlzILMgW4gWiAtIFlvdVR1YmUubXA0-.mp4',
        '61Jv7TCVekPFucDFdUqP95983E6JyR-metaV2hhdCBpcyBQeXRob24tIFdoeSBQeXRob24gaXMgU28gUG9wdWxhci0gLSBZb3VUdWJlLm1wNA==-.mp4',
        'bWhqhns8CfSTDPeAdSYAPyxAswTwnn-metaSG93IHRvIFNvcnQgTGlzdHMgaW4gUHl0aG9uIC0gUHl0aG9uIFR1dG9yaWFsIGZvciBBYnNvbHV0ZSBCZWdpbm5lcnMgLSBNb3NoIC0gWW91VHViZS5tcDQ=-.mp4',
        'cpVWHa7zPDRyBWpdKN9MEjS6Gc9iMT-metaV2hhdCBpcyBQeXRob24tIFdoeSBQeXRob24gaXMgU28gUG9wdWxhci0gLSBZb3VUdWJlLm1wNA==-.mp4'
    ];

    /**
     * Run the database seeds.
     * @throws RandomException|Throwable
     */
    public function run(): void
    {
        $instructors = User::where('role', 'instructor')->get();

        $courses = Course::factory()
            ->count(50)
            ->state(fn() => ['user_id' => $instructors->random()->id])
            ->create();

        foreach ($courses as $course) {
            $moduleCount = random_int(3, 10);
            for ($i = 1; $i <= $moduleCount; $i++) {
                $lessonCount = random_int(3, 10);
                $module = $this->generateModule($lessonCount, $i, $course->id);
                for ($j = 1; $j <= $lessonCount; $j++) {
                    $this->generateLesson($module->id, $j);
                }
            }
            $course->update([
                'duration' => $course->modules->sum('duration'),
                'lesson_count' => $course->modules->sum('lesson_count'),
                'user_id' => $instructors->random()->id,
            ]);
        }
    }

    /**
     * @throws RandomException
     */
    private function generateModule(int $lessonCount, int $position, string $courseId): Module
    {
        return Module::create([
            'title' => fake()->sentence(random_int(3, 6)),
            'lesson_count' => $lessonCount,
            'position' => $position,
            'duration' => random_int(600, 7200),
            'course_id' => $courseId,
        ]);
    }

    /**
     * @throws RandomException
     */
    private function generateLesson(string|int $moduleId, int $position): void
    {
        $type = fake()->randomElement(array_keys(Lesson::$TYPES));
        $lesson = Lesson::create([
            'title' => fake()->sentence,
            'type' => $type,
            'position' => $position,
            'preview' => fake()->boolean(20),
            'module_id' => $moduleId,
            'duration' => 0,
        ]);
        if ($type === 'video') {
            $lesson->update([
                'duration' => random_int(300, 3600),
                'video_file_name' => fake()->randomElement($this->videoFileNames),
            ]);
        } elseif ($type === 'document') {
            $lesson->update([
                'document' => fake()->paragraphs(20, true),
            ]);
        } else {
            $this->call(class: AssessmentSeeder::class, parameters: ['lessonId' => $lesson->id]);
        }
    }

}
