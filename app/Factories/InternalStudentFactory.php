<?php

namespace App\Factories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InternalStudentFactory {
    public static function createMany(array $students): void
    {
        $factory = new self();

        DB::transaction(function () use ($factory, $students) {
            foreach ($students as $data) {
                $factory->create($data);
            }
        });
    }

    public function create(array $data): void
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);

        $user->studentProfile()->create([
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'major_id' => $data['major_id'],
            'class_room_id' => $data['classroom_id'],
            'student_code' => $data['student_code'],
            'enrollment_year' => $data['enrollment_year'],
            'student_type' => 'internal',
        ]);

        $user->assignRole('student');
    }
}
