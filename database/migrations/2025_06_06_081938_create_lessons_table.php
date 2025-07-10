<?php

use App\Models\Course;
use App\Models\Lesson;
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
        Schema::create('lessons', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedTinyInteger('position');
	        $table->unsignedSmallInteger('duration')->comment('Duration in seconds and max 65535 seconds (18 hours)');
	        $table->boolean('preview')->default(false);
            $table->enum('type', Lesson::$TYPES);
            $table->json('resources')->nullable();

	        $table->foreignUuid('module_id')->constrained('modules');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
