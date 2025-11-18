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
use Spatie\Permission\Models\Role;
use Throwable;

class CourseSeeder extends Seeder
{
    public array $courseTitles = [
        'Mastering Laravel: From Beginner to Pro',
        'Advanced React Patterns for Modern Web Apps',
        'Building Scalable APIs with PHP and Lumen',
        'Clean Code Principles in Practice',
        'Full-Stack Web Development with the TALL Stack',
        'Docker & Kubernetes: The Complete Guide',
        'JavaScript Algorithms and Data Structures Masterclass',
        'Design Patterns in PHP for the Real World',
        'Test-Driven Development (TDD) in Laravel',
        'Building an E-commerce Platform with Livewire',
        'Vue.js 3: The Complete Guide (incl. Vue Router & Vuex)',
        'Node.js, Express, MongoDB & More: The Complete Bootcamp',
        'Python for Everybody: From Zero to Hero',
        'Advanced SQL and Database Management',
        'Git & GitHub: A Practical Guide for Developers',
        'TypeScript: The Complete Developer\'s Guide',
        'Next.js 14 & React: The Complete Guide',
        'Modern CSS with Flexbox, Grid, and Animations',
        'Svelte.js: The Complete Guide',
        'Webpack 5: From Beginner to Expert',
        'Web Performance Optimization: The Ultimate Guide',
        'Microfrontends: Architecture for Modern Web Apps',
        'UI/UX Design Fundamentals for Developers',
        'Three.js and WebGL for 3D Web Graphics',
        'State Management with Redux and Zustand',
        'Go (Golang): The Complete Developer\'s Guide',
        'Building Microservices with Node.js and NestJS',
        'Python and Django Full-Stack Web Developer Bootcamp',
        'Java Spring Boot for Modern Backend Development',
        'GraphQL with Apollo Server and React',
        'Building Real-Time Apps with WebSockets and Socket.IO',
        'Serverless Architecture with AWS Lambda and Node.js',
        'Introduction to gRPC for API Development',
        'Message Queues with RabbitMQ and Kafka',
        'API Security: Best Practices for Developers',
        'AWS Certified Solutions Architect - Associate 2025',
        'CI/CD Pipelines with GitHub Actions and Jenkins',
        'Infrastructure as Code with Terraform and Ansible',
        'Google Cloud Platform (GCP) Fundamentals',
        'Microsoft Azure from Scratch for Developers',
        'Container Orchestration with Docker Swarm',
        'Monitoring and Logging with Prometheus and Grafana',
        'Linux Command Line Bootcamp for Developers',
        'Network Fundamentals for Software Engineers',
        'Building a Serverless Backend on Firebase',
        'PostgreSQL: Advanced Concepts and Performance Tuning',
        'MongoDB - The Complete Developer\'s Guide',
        'Redis: The Complete In-Memory Data Store Course',
        'Elasticsearch: From Zero to Hero',
        'Database Design and Modeling Masterclass',
        'Flutter & Dart - The Complete Guide [2025 Edition]',
        'React Native: Advanced Concepts',
        'iOS & Swift - The Complete iOS App Development Bootcamp',
        'Android Java Masterclass - Become an App Developer',
        'Progressive Web Apps (PWA) - The Complete Guide',
        'System Design Interview Guide: From A to Z',
        'SOLID Principles and Object-Oriented Design',
        'Software Architecture: Patterns and Principles',
        'Agile & Scrum Master Certification Prep',
        'Domain-Driven Design (DDD) in Practice',
        'End-to-End Testing with Cypress and Playwright',
        'Unit Testing and Mocking in JavaScript with Jest',
        'Automated Software Testing with Selenium WebDriver',
        'Behavior-Driven Development (BDD) with Cucumber',
        'API Testing with Postman and Newman',
        'Introduction to Machine Learning with Python & Scikit-Learn',
        'Data Analysis with Pandas and NumPy',
        'Data Visualization with D3.js',
        'Building Chatbots with Dialogflow and Node.js',
        'TensorFlow for Beginners',
        'Web Security Fundamentals: Hacking and Hardening',
        'OAuth 2.0 and OpenID Connect in Depth',
        'Ethical Hacking: From Scratch to Advanced Techniques',
    ];

    public array $courseHeadings = [
        'Use Next.js 15, React 19, TypeScript, and Prisma to build a real-world, full-stack e-commerce website from scratch.',
        'Sharpen your problem-solving skills by building 50+ quick, unique, and fun mini-projects with vanilla HTML, CSS, and JavaScript.',
        'Master the TALL stack by creating a dynamic, real-time project management dashboard with Livewire, Alpine.js, and Laravel.',
        'Become a backend professional by designing and developing high-performance microservices with Go (Golang), gRPC, and Docker.',
        'Create a production-ready GraphQL API with NestJS, TypeORM, and PostgreSQL, complete with authentication and testing.',
        'Build a beautiful, cross-platform mobile app for both iOS and Android from a single codebase using Flutter and Firebase.',
        'Go from zero to a published app on the App Store and Google Play using React Native, Expo, and native device features.',
        'Level up your CSS skills by recreating 25+ modern, responsive, and beautifully animated website layouts from popular sites.',
        'Master data structures and algorithms by solving over 100 common interview questions in both JavaScript and Python.',
        'Design and build a complete social media platform with real-time features using the MERN stack and Socket.IO.',
        'Deepen your understanding of SQL by tackling advanced queries, database performance tuning, and optimization challenges.',
        'Learn software architecture fundamentals by designing and documenting 5 complex systems, from monoliths to microservices.',
        'Build a blazingly fast, server-rendered blog application with SvelteKit, TailwindCSS, and a headless CMS.',
        'Become a DevOps expert by automating CI/CD pipelines for 10 different real-world application scenarios using GitHub Actions.',
        'Develop a reactive, type-safe single-page application (SPA) using Vue 3, Pinia for state management, and TypeScript.',
        'Master Infrastructure as Code by deploying and managing a scalable web application on AWS using Terraform and Ansible.',
        'Build a real-time chat application with Elixir, Phoenix, and WebSockets to handle millions of connections.',
        'Explore the JAMstack ecosystem by creating a secure and scalable portfolio website with Astro, Sanity CMS, and Vercel.',
        'Go from junior to senior developer by refactoring legacy codebases and applying modern SOLID principles and design patterns.',
        'Create intelligent applications by integrating OpenAI and other AI APIs into a modern Node.js backend.',
        'Build a complex, data-intensive web application using Python, Django, Celery for background tasks, and Redis for caching.',
        'Master end-to-end testing by creating a robust testing suite for a complex web application using Cypress and Playwright.',
    ];

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
        $instructorRole = Role::findByName('instructor');
        $instructors = $instructorRole->users;

        $courseStates = [
            ['count' => 100, 'status' => 'published'],
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
                        'title' => count($seeder->courseTitles) > 0
                            ? array_shift($seeder->courseTitles)
                            : fake()->unique()->sentence(random_int(5, 10)),

                        'heading' => count($seeder->courseHeadings) > 0
                            ? array_shift($seeder->courseHeadings)
                            : fake()->sentence(random_int(15, 20)),

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
