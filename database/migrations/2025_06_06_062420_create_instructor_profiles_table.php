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
            $table->text('bio')->nullable();
            $table->string('heading')->nullable();
            $table->unsignedInteger('student_count')->default(0);
            $table->unsignedInteger('course_count')->default(0);
            $table->unsignedInteger('review_count')->default(0);
            $table->decimal('rating', 2, 1)->default(0);
            $table->json('social_links')->nullable();

            $table->foreignIdFor(User::class)->primary();

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
