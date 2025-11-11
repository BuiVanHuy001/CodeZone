<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Quản lý Khóa học (Courses)
            'view_course',
            'create_course',
            'update_course',
            'delete_course',

            // Quản lý Đăng ký (Enrollments)
            'enroll_course',
            'manage_enrollments',

            // Quản lý Người dùng (Users)
            'view_users',
            'create_user',
            'update_user',
            'delete_user',

            // Quản lý Nội dung (Lessons)
            'manage_lessons',
            'view_lesson',

            // Quản lý Nội bộ (Internal)
            'view_internal_courses'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // === Vai trò STUDENT ===
        $studentRole = Role::create(['name' => 'student', 'guard_name' => 'web']);
        $studentRole->givePermissionTo([
            'view_course',
            'enroll_course',
            'view_lesson'
        ]);

        // === Vai trò TEACHER ===
        $instructorRole = Role::create(['name' => 'instructor', 'guard_name' => 'web']);
        $instructorRole->givePermissionTo([
            'view_course',
            'create_course',
            'update_course',
            'manage_enrollments',
            'manage_lessons',
            'view_lesson',
            'view_internal_courses'
        ]);

        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'delete_course',
            'manage_enrollments',
            'view_users',
            'create_user',
            'update_user',
            'delete_user',

            'view_course',
            'create_course',
            'update_course',
            'manage_lessons',
            'view_lesson',
            'view_internal_courses'
        ]);

        $adminUser = User::where('email', 'admin@codezone.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        }

        $instructorUser = User::where('email', 'taylorotwell@codezone.com')->first();
        if ($instructorUser) {
            $instructorUser->assignRole($instructorRole);
        }

        $students = User::whereNotIn('email', [
            'admin@codezone.com',
            'taylorotwell@codezone.com'
        ])->get();

        foreach ($students as $student) {
            if (!$student->hasRole('student')) {
                $student->assignRole($studentRole);
            }
        }
    }
}
