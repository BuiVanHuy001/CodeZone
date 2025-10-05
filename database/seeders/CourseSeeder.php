<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use JsonException;
use Random\RandomException;
use Throwable;

class CourseSeeder extends Seeder
{
    public array $videoFileNames = [
        'intro_to_python.mp4',
        'javascript_basics.mp4',
        'what_is_python.mp4',
        'sorting_in_python.mp4',
        'python_popularity.mp4'
    ];

    public array $skills = [
        'Master the art of writing clean and maintainable JavaScript code, a valuable skill for any developer.',
        'Develop strong problem-solving skills to tackle complex coding challenges with confidence.',
        'Gain the ability to design scalable and efficient database schemas.',
        'Learn to apply object-oriented programming principles in real-world projects.',
        'Understand how to optimize web applications for maximum performance.',
        'Practice writing unit tests to ensure code reliability and maintainability.',
        'Acquire hands-on experience with version control systems like Git.',
        'Strengthen your understanding of data structures and algorithms.',
        'Learn how to architect and build RESTful APIs from scratch.',
        'Master the principles of responsive web design for modern devices.',
        'Develop practical skills in debugging and troubleshooting code issues.',
        'Understand security best practices to build safe and secure applications.',
        'Gain experience with agile and collaborative development workflows.',
        'Improve your knowledge of functional programming concepts.',
        'Learn to write reusable and modular code components.',
        'Build the ability to integrate third-party libraries and services.',
        'Understand design patterns and their applications in software development.',
        'Practice effective code refactoring to enhance readability and performance.',
        'Develop skills to manage state in complex applications.',
        'Acquire hands-on experience deploying applications to production environments.',
        'Learn techniques for improving search engine optimization (SEO) in web projects.',
        'Gain insights into cloud computing and containerization technologies.',
        'Understand the fundamentals of UX/UI principles in application development.',
        'Master the use of automation tools for testing and deployment.',
        'Enhance your collaboration skills by working with code review processes.',
        'Learn to design and consume GraphQL APIs effectively.',
        'Build the ability to analyze and interpret system performance metrics.',
        'Develop critical thinking to choose the right technology stack for projects.',
        'Gain confidence in presenting and documenting your technical solutions.',
    ];

    private array $requirements = [
        'beginner' => [
            'No prior experience required – suitable for beginners',
            'A computer with stable internet access',
            'Basic computer skills such as browsing and software installation',
            'A strong willingness to learn and explore new concepts',
            'Ability to follow step-by-step instructions',
            'Motivation to practice regularly',
            'Patience and persistence when facing challenges',
            'Comfortable with typing and navigating the internet',
            'Basic understanding of English for technical terms',
            'Interest in technology and problem-solving',
            'Willingness to ask questions and seek help',
            'Ability to dedicate at least 1–2 hours per week',
            'Openness to learning from mistakes and improving',
        ],
        'intermediate' => [
            'Basic understanding of the subject or completion of beginner-level course',
            'A computer with at least 8GB RAM',
            'Familiarity with relevant tools and software',
            'Ability to commit 3–5 hours per week',
            'At least 6 months of relevant practical experience',
            'Comfortable reading technical documentation',
            'Understanding of core programming concepts',
            'Ability to troubleshoot simple errors independently',
            'Some experience with collaborative tools like Git',
            'Willingness to work on small projects for practice',
            'Basic knowledge of operating systems (Windows, macOS, Linux)',
            'Ability to manage time effectively for self-paced learning',
            'Motivation to improve and progress to advanced skills',
        ],
        'advanced' => [
            'Minimum 2 years of professional experience in the field',
            'A high-performance workstation or laptop',
            'Proficiency with advanced tools and workflows',
            'Ability to commit 5–10 hours of study per week',
            'Previous participation in real-world projects with a portfolio',
            'Comfortable with solving complex technical problems',
            'Familiarity with industry standards and best practices',
            'Ability to work independently with minimal guidance',
            'Strong analytical and critical thinking skills',
            'Experience with collaboration in large teams',
            'Knowledge of deployment and production environments',
            'Confidence in experimenting with cutting-edge technologies',
            'Motivation to specialize or become an expert in the field',
        ],
    ];

    public array $targetAudience = [
        'Beginners who want to explore coding as a career path.',
        'Students looking to strengthen their technical foundation.',
        'Professionals aiming to transition into tech roles.',
        'Freelancers who want to expand their skill set.',
        'Entrepreneurs planning to build their own applications.',
        'Junior developers seeking to refine clean coding practices.',
        'Web designers wanting to move into full-stack development.',
        'Data enthusiasts curious about programming for data analysis.',
        'IT professionals needing to refresh their skills.',
        'Anyone passionate about learning problem-solving through code.',
        'Educators interested in teaching programming concepts.',
        'Hobbyists who enjoy creating software as a side project.',
        'Non-technical employees wishing to understand coding basics.',
        'Career changers transitioning into technology-related fields.',
        'Students preparing for coding interviews and internships.',
        'Self-taught programmers looking for structured guidance.',
        'Managers who want a better understanding of development workflows.',
        'Startup founders wanting to prototype their product.',
        'High school graduates preparing for computer science majors.',
        'Designers aiming to enhance their frontend development knowledge.',
        'People interested in building websites or mobile apps.',
        'Content creators who want to automate workflows.',
        'Anyone seeking an in-demand skill for the digital economy.',
        'Corporate teams who want to upskill in software development.',
        'Technology enthusiasts who enjoy hands-on learning.',
        'Adults returning to education for professional growth.',
        'Students from non-IT majors curious about coding basics.',
        'Freelancers aiming to offer programming as a new service.',
    ];

    /**
     * @throws RandomException
     */
    public function run(): void
    {
        $instructors = User::where('role', 'instructor')->get();
        $seeder = $this;

        $courses = Course::factory()
            ->count(50)
            ->state(function () use ($seeder, $instructors) {
                return [
                    'user_id' => $instructors->random()->id,
                    'skills' => $seeder->generateSkills(),
                    'requirements' => $seeder->generateRequirements(),
                    'target_audiences' => $seeder->generateTargetAudience(),
                ];
            })
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
                'lesson_count' => $course->modules->sum('lesson_count')
            ]);
        }
    }

    /**
     * @throws JsonException
     */
    private function generateSkills(): string
    {
        $skills = fake()->randomElements(
            $this->skills,
            fake()->numberBetween(4, 10)
        );

        return json_encode(array_map(static fn($skill) => ['name' => $skill], $skills), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @throws JsonException
     */
    private function generateRequirements(): string
    {
        $level = fake()->randomElement(array_keys($this->requirements));
        $requirements = fake()->randomElements(
            $this->requirements[$level],
            fake()->numberBetween(4, 10)
        );

        return json_encode(array_map(static fn($req) => ['name' => $req], $requirements), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    /**
     * @throws JsonException
     */
    private function generateTargetAudience(): string
    {
        $audience = fake()->randomElements(
            $this->targetAudience,
            fake()->numberBetween(4, 10)
        );

        return json_encode(array_map(static fn($aud) => ['name' => $aud], $audience), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
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
