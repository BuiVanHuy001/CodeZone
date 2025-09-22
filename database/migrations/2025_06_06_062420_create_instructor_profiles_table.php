<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instructor_profiles', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->primary();
	        $table->text('bio')->nullable();
	        $table->text('about_me')->nullable();
            $table->string('current_job', 100)->nullable();

            $table->json('social_links')->nullable();

            $table->mediumInteger('course_count')
                ->default(0)
                ->comment('Number of courses created by the instructor and max 65535 courses');
            $table->Integer('student_count')
                ->default(0)
                ->comment('Total number of students enrolled in the instructor\'s courses and max 2,147,483,647 students');
            $table->decimal('rating', 3)
                ->default(0.00)
                ->comment('Average rating of the instructor\'s courses, e.g., 4.50');
            $table->Integer('review_count')
                ->default(0)
                ->comment('Total number of reviews received for the instructor\'s courses and max 2,147,483,647 reviews');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_profiles');
    }
};
