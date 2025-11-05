<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(500)->create();
        foreach ($users as $user) {
            $user->update([
                'avatar' => 'https://avatar.iran.liara.run/public/' . random_int(1, 70),
            ]);
            $user->studentProfile()->create([
                'gender' => fake()->boolean(),
                'dob' => fake()->date(),
            ]);
        }

        $approvedInstructors = User::factory(40)->create([
            'role' => 'instructor',
            'status' => 'active',
        ]);

        foreach ($approvedInstructors as $user) {
            $user->update([
                'avatar' => 'https://static.generated.photos/vue-static/face-generator/landing/wall/' . random_int(1, 24) . '.jpg'
            ]);
            $user->instructorProfile()->create([
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
            'role' => 'instructor',
            'status' => 'pending',
        ]);

        foreach ($pendingInstructors as $user) {
            $user->instructorProfile()->create();
        }
    }
}
