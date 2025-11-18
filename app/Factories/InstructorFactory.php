<?php

namespace App\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InstructorFactory {

    public function store(array $data): ?User
    {
        try {
            \DB::transaction(function () use ($data) {
                if ($data['avatar'] && empty($data['avatarLink'])) {
                    $this->storeAvatar($data['avatar']);
                }
                $instructor = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'avatar' => $data['avatar'] ?? $data['avatarLink'] ?? null,
                ])->assignRole('instructor')
                                  ->instructorProfile()->create([
                        'major_id' => $data['major_id'] ?? null,
                    ]);
                return $instructor;
            });
        } catch (\Exception $e) {
            report($e);
            return null;
        }
        return null;
    }

    private function storeAvatar() {}
}
