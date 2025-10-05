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
        $users = User::factory(300)->create();
        foreach ($users as $user) {
            $user->update([
                'avatar' => 'https://avatar.iran.liara.run/public/' . random_int(1, 70),
            ]);
            $user->studentProfile()->create([
                'gender' => fake()->boolean(),
                'dob' => fake()->date(),
            ]);
        }
        $instructor = User::factory(20)->create([
            'role' => 'instructor',
        ]);
        foreach ($instructor as $user) {
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

        $organizations = User::factory(5)->create([
            'role' => 'organization',
        ]);
        foreach ($organizations as $user) {
            $user->organizationProfile()->create([
                'bio' => fake()->company(),
                'about_me' => fake()->paragraphs(3, true),
                'social_links' => [
                    'facebook' => fake()->url(),
                    'twitter' => fake()->url(),
                    'linkedin' => fake()->url(),
                    'github' => fake()->url(),
                ],
            ]);
        }
    }
}
