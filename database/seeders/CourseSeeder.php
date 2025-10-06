<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use JsonException;
use Random\RandomException;
use Throwable;

class CourseSeeder extends Seeder
{
    public array $videoFileNames = [
        '7sPOPfpibvEJyIi17SpvHFZ9wDOYAy-metaIzQgQlVJTEQgJiBDSEHMo1kgSU1BR0UgVcybzIFORyBEVcyjTkcgTk9ERS5KUyBWT8ybzIFJIERPQ0tFUiAtIERvY2tlciBTaWXMgnUgRGXMgsyDIENobyBCZWdpbm5lcnMgVHXMm8yAIEEgxJFlzILMgW4gWiAtIFlvdVR1YmUubXA0-.mp4',
        'bWhqhns8CfSTDPeAdSYAPyxAswTwnn-metaSG93IHRvIFNvcnQgTGlzdHMgaW4gUHl0aG9uIC0gUHl0aG9uIFR1dG9yaWFsIGZvciBBYnNvbHV0ZSBCZWdpbm5lcnMgLSBNb3NoIC0gWW91VHViZS5tcDQ=-.mp4',
        'cpVWHa7zPDRyBWpdKN9MEjS6Gc9iMT-metaV2hhdCBpcyBQeXRob24tIFdoeSBQeXRob24gaXMgU28gUG9wdWxhci0gLSBZb3VUdWJlLm1wNA==-.mp4',
        'Hwvn1EhU5OBptQBQMecYjsN6NpL83T-metaTWFwIGFuZCBGaWx0ZXIgRnVuY3Rpb25zIGluIFB5dGhvbiAtIFB5dGhvbiBUdXRvcmlhbCBmb3IgQWJzb2x1dGUgQmVnaW5uZXJzIC0gTW9zaCAtIFlvdVR1YmUubXA0-.mp4',
        'kfA5MwEHnyBHWFlYALBHxewpzNXmfS-metaIzEgRE9DS0VSIExBzIAgR0nMgCAtIFRBzKNJIFNBTyBDSFXMgU5HIFRBIExBzKNJIENBzILMgE4gRE9DS0VSIC0gLSBEb2NrZXIgU2llzIJ1IERlzILMgyBDaG8gTmd1zJtvzJvMgGkgTW_Mm8yBaSBCYcyGzIF0IMSQYcyCzIB1IC0gWW91VHViZS5tcDQ=-.mp4'
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

    public array $thumbnailFileNames = [
        'a4fge8HjKLpBCxwz1nPQo9sT5uVZY2mR-metaODU5MTQ4X2FydGlzdGljLnBng-2025.webp',
        'c9hVw2MNTyGQRk3bZ6sL1uJpAeXF4oD5-metaMTEzNjc5X2Vjb21tZXJjZS5qcGc-2025.webp',
        'b7kPq5RSfXZALm3jDcWvU0iYtE6gNnOH-metaNDAzMjE5X2Z1bmdhbS5wbmc-2025.webp',
        'd1rXz6LpUTjIYgCq2eVh9kBfM0sN7dOZ-metaOTAxNTM4X21hcmtldGluZy5wbmc-2025.webp',
        'e8sTy1GfWbOIHZk7QcD9xUaN3vP6lYJR-metaMTIzOTg3X3RyYXZlbC5qcGc-2025.webp',
        'f3uVb9XmKjRPLo4iTdQz6sGhA5cE1yFW-metaNzQxNTYwX3NjaWVuY2UucG5n-2025.webp',
        'g6wZa0CdEuXFh8yBvJpL2tM4rNqS5iOG-metaMjIwMzQ1X2Zhc2hpb24uanBn-2025.webp',
        'h0xBc7YdDkGvP2uMz9lFw4sTjO5aI8QE-metaODExNzYyX2hlYWx0aC5wbmc-2025.webp',
        'i5yDe2ZgFmHwQ1tNr0oKs3pLb6cR7jSA-metaNDQ1MjczX3Rlc3Rpbmcud2VicA-2025.webp',
        'j2zEf4AgaIiXx0vOs8rPu7qKy5wM9nBT-metaNTg3MTIzX2Jsb2dnZXIuSlBn-2025.webp',
        'k7aFg9BhcJjYuR1pQw6lVz8sT3mN2oCU-metaMjc5MDQxX2RhdGFzY2llbmNlX3d0dG1sbi5wbmc-2025.webp',
        'JsGqggVjHuF9OYBGwHyTO6WoPbbpy3kD-metaNTIxMzExX2x5ZGt5Zi53ZWJw-.webp',
        'vIEKksQGMIN42SCBOUo8CzGwhfaqHMTd-metaODEwODc4X2VrcmtiYy53ZWJw-.webp',
        'WPllbkj9olZP9dJBYaFAl0IneNJXUBEC-metaMzEyNjMxX292aW5laC53ZWJw-.webp',
        'z5OEDuqVIMuydBqSz2TiNH4Aq1a01Rbs-metaMzkzNjc4X2NobHV0bi53ZWJw-.webp',
        'uzm3u0c3c71igbxpQWvd7GmbdcXC40A7-metaNDM2MzE0X2FzZWp2cC53ZWJw-.webp',
        'gYpaPhQ3guTJKrtBHkDrLyybkhlbDhWJ-metaNTA5NDk0X2pub29raC53ZWJw-.webp',
        '6vxAmZ5pcpuD6UgTxFb3WmKnTykbXMMM-metaMjgxOTgzX2hndnlycy53ZWJw-.webp',
        'ogXSfjdwNzy3kV7fIHHevweD3SVCRnT8-metaMjc3OTM5X25uYXdubC53ZWJw-.webp',
        'iXXUYXydCXl6tutNg5AiR8n2Hfabdrcj-metaOTQwMTMyX3h3d21tZC53ZWJw-.webp',
        'MdfpkRzllCroUJ0K0nTWfKMySikD7QVB-metaNTU5ODA1X2hienpsai53ZWJw-.webp',
        'fa7tPX1TJsjqBQwC2RRLpWUXvUIdA6HW-metaMzYzOTQ0X3J0Y2RvcC53ZWJw-.webp',
        '9dnPPECpNyz2PoYnc02xtsNbOQtcjX2X-metaNjAyNTQxX3RiZ2xraC53ZWJw-.webp',
        '1mx9F4xw8cGr3JWlJW6jd6hSvNNtcWVk-metaNjMzMDUyX25qenpjdC53ZWJw-.webp',
        'fp9IGaUU0fC0wrwCfFj6gfQ5bO5OEI8A-metaNzU3NjQ1X3JyZ2tzZy53ZWJw-.webp',
        'UGx7sun7neRRTuEDquYBfJioyd7xIncm-metaMjg2NTQxX25hbGJjai53ZWJw-.webp',
        'YlscXOTnunH031fZaEUoMrBUGhakNZwc-metaMjY5OTQ2X2VyZ25pZS53ZWJw-.webp',
        'edluciOZuDRFakwtuq6bfuraeeziEmmq-metaNTkxNTk3X2plbmp0Zy53ZWJw-.webp',
        'JoE8KboCKgFkvnvU3NFlKW4V8M7ndlGX-metaMTUxNDk0X2pkbGV3by53ZWJw-.webp',
        'lRtnvQPgLES54eajvEmNv81sxJsCtaUG-metaMzA5NjIzX2lwamJpci53ZWJw-.webp',
        'tu2dih3DTf7EAqrsiRsZs1eNTAYs5hKK-metaNjMyMDUyX3d0dG1sbi53ZWJw-.webp',
    ];

    public function run(): void
    {
        $instructors = User::where('role', 'instructor')->get();

        $courseStates = [
            ['count' => 50, 'status' => 'published'],
            ['count' => 20, 'status' => 'draft'],
            ['count' => 20, 'status' => 'pending'],
            ['count' => 30, 'status' => 'rejected'],
        ];

        $seeder = $this;

        $courses = [];
        foreach ($courseStates as $state) {
            $courses[] = Course::factory($state['count'])
                ->state(function () use ($instructors, $state, $seeder) {
                    return [
                        'user_id' => $instructors->random()->id,
                        'status' => $state['status'],
                        'skills' => $seeder->generateSkills(),
                        'requirements' => $seeder->generateRequirements(),
                        'target_audiences' => $seeder->generateTargetAudience(),
                    ];
                })
                ->create();
        }

        $courses = collect($courses)->flatten(1);

        foreach ($courses as $course) {
            $moduleCount = random_int(3, 10);
            for ($i = 1; $i <= $moduleCount; $i++) {
                $lessonCount = random_int(3, 10);
                if (!isset($course->id)) {
                    dd($course);
                }
                $module = $this->generateModule($lessonCount, $i, $course->id);
                for ($j = 1; $j <= $lessonCount; $j++) {
                    $this->generateLesson($module->id, $j);
                }
            }
            $thumbnail = array_shift($this->thumbnailFileNames);

            $course->update([
                'thumbnail' => $thumbnail,
                'duration' => $course->modules->sum('duration'),
                'lesson_count' => $course->modules->sum('lesson_count')
            ]);
        }
    }

    private function generateSkills(): string
    {
        $skills = fake()->randomElements(
            $this->skills,
            fake()->numberBetween(4, 10)
        );

        return json_encode(array_map(static fn($skill) => ['name' => $skill], $skills), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    private function generateRequirements(): string
    {
        $level = fake()->randomElement(array_keys($this->requirements));
        $requirements = fake()->randomElements(
            $this->requirements[$level],
            fake()->numberBetween(4, 10)
        );

        return json_encode(array_map(static fn($req) => ['name' => $req], $requirements), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

    private function generateTargetAudience(): string
    {
        $audience = fake()->randomElements(
            $this->targetAudience,
            fake()->numberBetween(4, 10)
        );

        return json_encode(array_map(static fn($aud) => ['name' => $aud], $audience), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }

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
