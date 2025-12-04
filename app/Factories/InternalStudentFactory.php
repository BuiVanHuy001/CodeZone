<?php

namespace App\Factories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InternalStudentFactory {
    public static function createMany(array $students): Collection
    {
        return DB::transaction(function () use ($students) {
            $factory = new self();

            return collect($students)->map(function ($data) use ($factory) {
                return $factory->create($data);
            });
        });
    }

    public function create(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'] ?: $data['student_code']),
            'status' => 'active',
        ]);

        $user->studentProfile()->create([
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'major_id' => $data['major_id'] ?? null,
            'class_room_id' => $data['classroom_id'] ?? null,
            'student_code' => $data['student_code'],
            'enrollment_year' => $data['enrollment_year'] ?? now()->year,
            'student_type' => 'internal',
        ]);

        $user->assignRole('student');

        return $user;
    }
}
