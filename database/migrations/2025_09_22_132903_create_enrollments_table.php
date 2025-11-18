<?php

use App\Models\Enrollment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', static function (Blueprint $table) {
            $table->foreignUuid('course_id')->constrained('courses');
            $table->foreignUuid('user_id')->constrained('users');
            $table->primary(['course_id', 'user_id']);

            $table->enum('status', array_keys(Enrollment::$STATUSES))->default('not_started');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
