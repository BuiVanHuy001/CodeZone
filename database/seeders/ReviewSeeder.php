<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run method without parameters for Laravel seeder system
     */
    public function run(): void
    {
        // Empty - used by Laravel's seeder system
    }

    public function createReview(string|int $userId, mixed $reviewable, int $rating): void
    {
        if (!$reviewable) {
            return;
        }

        $reviewableType = get_class($reviewable);

        $unique = [
            'user_id' => $userId,
            'reviewable_id' => $reviewable->id,
            'reviewable_type' => $reviewableType,
        ];

        if ($reviewable instanceof Course) {
            $content = $this->generateCourseReviewContentByRating($rating);
        } else {
            $content = $this->generateInstructorReviewContentByRating($rating);
        }

        Review::firstOrCreate(
            $unique,
            [
                'content' => $content,
                'rating' => $rating,
            ]
        );
    }

    private function generateCourseReviewContentByRating(int $rating): string
    {
        return match ($rating) {
            5 => fake()->randomElement([
                'Outstanding course! Everything was explained so clearly and thoroughly.',
                'Absolutely loved this course — it exceeded my expectations in every way.',
                'The best course I’ve taken online. Easy to follow and full of practical examples.',
                'Top-notch content! The lessons are well-paced and engaging.',
                'I finally understand this topic thanks to this course. Brilliant job!',
                'Very high-quality materials and excellent teaching style.',
                'This course is a must for anyone who wants to master the subject.',
                'Perfect structure and examples — made complex topics easy to grasp.',
                'Instructor’s teaching style is excellent. Great visuals and clear explanations.',
                'I learned more here than in an entire semester at university!',
                'Professional and well-produced. Would rate 10 stars if I could!',
                'Hands down the best online course experience I’ve had.',
                'Extremely well thought out, from start to finish.',
                'Every module builds perfectly on the previous one.',
                'The quizzes really help reinforce what you learn.',
                'Fantastic combination of theory and practice.',
                'A great learning journey — I felt supported the whole time.',
                'The real-world examples made everything so much clearer.',
                'Brilliant design, content, and execution.',
                'I feel confident applying what I learned in real projects.',
                'I would recommend this to all my colleagues.',
                'Very interactive and enjoyable learning experience.',
                'This course helped me land my first job in the field!',
                'Thorough, inspiring, and well worth the investment.',
                'Exactly what I needed — clear, concise, and useful!',
            ]),
            4 => fake()->randomElement([
                'Very good course with great examples and useful insights.',
                'Well-structured content and easy to follow.',
                'Solid course overall, though a few lessons could be updated.',
                'Great explanations and exercises, just wish there were more projects.',
                'The course was very helpful in understanding key concepts.',
                'Learned a lot, though some sections were a bit fast-paced.',
                'Really good introduction to the topic — worth the price.',
                'Very informative, with clear instructions and explanations.',
                'Useful material and practical examples throughout.',
                'A couple of videos were outdated, but still valuable.',
                'Engaging course with solid fundamentals.',
                'Great for intermediate learners — not too easy, not too hard.',
                'I feel more confident after completing this course.',
                'The course flow was logical and easy to follow.',
                'Loved the teaching style. Could use a few more exercises though.',
                'Enjoyed it a lot. Would take another course from this instructor.',
                'Some topics could have been explored more deeply.',
                'Clear and concise — I learned something new in every lesson.',
                'Practical and informative with a professional tone.',
                'Overall a great learning experience, highly recommend.',
                'Perfect for brushing up on existing skills.',
            ]),
            3 => fake()->randomElement([
                'The course was okay, but lacked depth in some areas.',
                'Average content. Some lessons felt repetitive.',
                'It’s fine for beginners, but too basic for experienced learners.',
                'Not bad, but I expected more hands-on projects.',
                'The examples were decent but could have been better explained.',
                'A bit outdated but still somewhat useful.',
                'Some lessons were clear, others quite confusing.',
                'Decent course but not as comprehensive as advertised.',
                'Content was okay, though not particularly engaging.',
                'Could use more quizzes or real-world exercises.',
                'Good start, but needs more detail in key sections.',
                'Instructor was knowledgeable but delivery was inconsistent.',
                'Average pacing. Some parts felt rushed.',
                'Not bad for a free course, but I wouldn’t pay full price.',
                'Overall fine, but not memorable.',
                'I learned a few things, though it lacked depth.',
                'Okay course but could have been structured better.',
                'Basic overview with limited depth on advanced topics.',
                'It’s okay if you just want a refresher.',
            ]),
            2 => fake()->randomElement([
                'Disappointing course. The explanations were confusing.',
                'Instructor did not seem prepared for some topics.',
                'Too much theory and not enough practice.',
                'The examples didn’t work as expected.',
                'Poorly organized and not engaging.',
                'Outdated material and missing key details.',
                'I struggled to follow along after a few lessons.',
                'Not worth the price. Needs major improvement.',
                'Sound and visuals were low quality.',
                'Course felt rushed and incomplete.',
                'Did not meet my expectations.',
                'Instructor read slides without explaining much.',
                'No support or feedback from the instructor.',
                'Many concepts were left unexplained.',
                'Too many errors and typos in the content.',
                'Would not recommend unless it’s updated.',
                'Lacked exercises or ways to test understanding.',
                'The pacing and examples were inconsistent.',
            ]),
            1 => fake()->randomElement([
                'Terrible course. Nothing was explained properly.',
                'Waste of time and money. Completely useless.',
                'Instructor had no idea what they were talking about.',
                'Misleading title. Content doesn’t match description.',
                'Awful experience from start to finish.',
                'The course was full of errors and incorrect information.',
                'Would give zero stars if I could.',
                'Worst online learning experience ever.',
                'Completely unstructured and confusing.',
                'Instructor sounded bored and unprepared.',
                'Videos didn’t even load properly. Very frustrating.',
                'No effort was put into this course at all.',
                'Unprofessional and poorly edited.',
                'The examples didn’t work and there was no help.',
                'Stay away from this course. Not worth it.',
                'Waste of time — I didn’t learn anything new.',
                'Sound quality terrible and slides unreadable.',
                'A complete mess from beginning to end.',
                'This course should be taken down.',
                'Incredibly disappointing and frustrating experience.',
            ]),
            default => fake()->sentences(random_int(1, 3), true),
        };
    }

    private function generateInstructorReviewContentByRating(int $rating): string
    {
        return match ($rating) {
            5 => fake()->randomElement([
                'Incredible instructor! Explains everything clearly and makes learning enjoyable.',
                'Very engaging and knowledgeable — makes difficult topics simple.',
                'Fantastic teaching style. Always patient and responsive.',
                'The instructor goes above and beyond to ensure understanding.',
                'Professional, passionate, and inspiring educator.',
                'Excellent communication and real-world examples.',
                'Truly one of the best teachers I’ve had online.',
                'Clear, concise, and motivating — highly recommended!',
                'Knows how to keep students engaged and interested.',
                'Makes complex concepts seem easy and intuitive.',
                'Always quick to respond to questions and provide feedback.',
                'Creates a welcoming and encouraging learning environment.',
                'Very dedicated and organized instructor.',
                'Helped me build real confidence in my skills.',
                'Outstanding teaching methods — consistent and insightful.',
                'The instructor clearly loves teaching and it shows.',
                'Perfect mix of humor, professionalism, and knowledge.',
                'Explains not just the “how” but the “why” behind each concept.',
                'Very approachable and attentive to students’ needs.',
                'This instructor deserves a standing ovation!',
                'Best instructor I’ve ever had on any platform.',
            ]),
            4 => fake()->randomElement([
                'Very good teacher — lessons are clear and structured.',
                'Helpful instructor with good communication skills.',
                'Great balance between theory and practice.',
                'Explains concepts well, though sometimes too quickly.',
                'Good feedback and guidance throughout the course.',
                'Supportive and responsive to student questions.',
                'Knows the material well and conveys it effectively.',
                'Good teaching overall, though a few lessons felt rushed.',
                'Practical teaching style that works well for me.',
                'Friendly and easy to follow along with.',
                'Great personality and good pacing.',
                'Instructor clearly knows the subject matter.',
                'One of the better instructors I’ve encountered online.',
                'Good at simplifying complex topics.',
                'Some lessons could use more examples, but overall great.',
                'Very professional and approachable.',
                'Good at keeping students motivated.',
                'Really helpful during Q&A sessions.',
                'Enjoyed learning from this instructor.',
            ]),
            3 => fake()->randomElement([
                'Decent instructor, but explanations could be clearer.',
                'Average teaching — sometimes engaging, sometimes confusing.',
                'Instructor knows the material but lacks energy.',
                'Okay overall, but lessons felt repetitive.',
                'Some explanations were too brief.',
                'Fairly good teacher, but delivery could be improved.',
                'Helpful but not very engaging.',
                'Instructor seemed distracted in some lessons.',
                'Good start, but needs more enthusiasm.',
                'Knows the subject but struggles to simplify it.',
                'Somewhat inconsistent quality between lessons.',
                'I learned a few things, but it wasn’t inspiring.',
                'Okay instructor for basic topics.',
                'Teaching style could be more interactive.',
                'Neutral experience — not bad, not great.',
            ]),
            2 => fake()->randomElement([
                'Instructor seems unsure about some topics.',
                'Teaching style is dry and unorganized.',
                'Difficult to follow and poorly explained.',
                'Not enough practical examples to understand the material.',
                'Instructor reads from slides without adding insights.',
                'Pacing was off and engagement was low.',
                'Unclear explanations and inconsistent structure.',
                'Limited student interaction or feedback.',
                'I had to look elsewhere to understand the topic.',
                'Content delivery felt robotic and uninspired.',
                'Instructor needs to work on communication skills.',
                'Not very approachable or responsive.',
                'Poorly prepared lessons and lack of structure.',
                'Disorganized teaching and repetitive phrasing.',
            ]),
            1 => fake()->randomElement([
                'Terrible instructor — completely unprepared.',
                'Did not explain anything clearly.',
                'Lacked both knowledge and enthusiasm.',
                'Felt like the instructor didn’t care at all.',
                'Awful teaching. I learned nothing.',
                'Unprofessional attitude and no feedback.',
                'Instructor ignored student questions entirely.',
                'Very disorganized and confusing delivery.',
                'Worst instructor I’ve ever seen.',
                'Monotone voice and no energy.',
                'Zero interaction or motivation.',
                'Completely wasted my time.',
                'Instructor barely knows the subject.',
                'Very disappointing and frustrating.',
                'Would never take another class from them.',
                'They need serious improvement before teaching again.',
                'Unhelpful, unprepared, and unprofessional.',
                'The explanations were flat-out wrong in some cases.',
                'Avoid this instructor at all costs.',
            ]),
            default => fake()->sentences(random_int(1, 3), true),
        };
    }
}
