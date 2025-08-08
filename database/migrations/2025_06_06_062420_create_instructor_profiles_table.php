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
	        $table->json('socials_links')->nullable();
	        $table->mediumInteger('course_count')->default(0); // max 16,383 courses
	        $table->Integer('student_count')->default(0); // max 2,147,483,647 students
	        $table->decimal('rating', 3, 2)->default(0.00);
	        $table->Integer('review_count')->default(0); // max 2,147,483,647 reviews
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
