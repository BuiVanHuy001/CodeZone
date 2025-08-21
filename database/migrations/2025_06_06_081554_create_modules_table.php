<?php

use App\Models\Course;
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
        Schema::create('modules', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
	        $table->unsignedTinyInteger('lesson_count');
            $table->unsignedTinyInteger('position');
	        $table->unsignedSmallInteger('duration')->comment('Duration in seconds and max 65535 seconds (18 hours)');

	        $table->foreignUuid('course_id')->constrained('courses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
