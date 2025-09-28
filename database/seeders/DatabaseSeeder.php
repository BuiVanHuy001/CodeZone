<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $sql = file_get_contents(database_path('codezone.sql'));
            \DB::unprepared($sql);
            $this->call(UserSeeder::class);
            $this->call(CourseSeeder::class);
            $this->call(EnrollmentSeeder::class);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
