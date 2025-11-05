<?php

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
        Schema::create('lessons', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
	        $table->text('document')->nullable();
            $table->string('video_file_name')->nullable();
            $table->unsignedTinyInteger('position');
            $table->unsignedSmallInteger('duration')
                ->comment('Duration in seconds and max 65535 seconds (18 hours)');
	        $table->boolean('preview')->default(false);
            $table->enum('type', array_keys(Lesson::$TYPES));
            $table->json('resources')->nullable();

            $table->foreignUuid('module_id')->constrained('modules')->cascadeOnDelete();

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
