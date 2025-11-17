<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(600)->create();
        $classRooms = ClassRoom::all();
        foreach ($users as $user) {
            $user->assignRole('student');
            $user->update([
                'avatar' => 'https://avatar.iran.liara.run/public/' . random_int(1, 70),
            ]);
            $user->studentProfile()->create([
                'gender' => fake()->boolean(),
                'dob' => fake()->date(),
            ]);

            if (fake()->boolean(80)) {
                $user->studentProfile()->update([
                    'student_type' => 'internal',
                    'major_id' => random_int(1, 17),
                    'student_code' => 'S' . str_pad((string)random_int(1, 999999), 6, '0', STR_PAD_LEFT),
                    'enrollment_year' => fake()->dateTimeBetween('-4 years', 'now')->format('Y-m-d'),
                    'class_room_id' => random_int(1, 28),
                ]);
            } else {
                $user->studentProfile()->update([
                    'student_type' => 'external',
                ]);
            }
            if (fake()->boolean(30)) {
                $user->update([
                    'status' => fake()->randomElement(User::$STATUSES)
                ]);
            }
        }

        $approvedInstructors = User::factory(40)->create([
            'status' => 'active',
        ]);

        foreach ($approvedInstructors as $user) {
            $user->assignRole('instructor');
            $user->update([
                'avatar' => 'https://static.generated.photos/vue-static/face-generator/landing/wall/' . random_int(1, 24) . '.jpg',
            ]);
            $user->instructorProfile()->create([
                'major_id' => random_int(1, 17),
                'bio' => fake()->paragraph(),
                'about_me' => fake()->paragraphs(3, true),
                'current_job' => fake()->jobTitle(),
                'social_links' => [
                    'facebook' => fake()->url(),
                    'twitter' => fake()->url(),
                    'linkedin' => fake()->url(),
                    'github' => fake()->url(),
                ],
            ]);
        }

        $pendingInstructors = User::factory(20)->create([
            'status' => 'pending',
        ]);

        foreach ($pendingInstructors as $user) {
            $user->assignRole('instructor');
            $user->instructorProfile()->create();
        }

    }
}
