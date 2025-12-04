<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('heading');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->decimal('price', 13, 3)
                ->default(0)
                ->comment('Price in VND (Vietnamese Dong)');

            $table->unsignedSmallInteger('enrollment_count')->default(0);
            $table->unsignedSmallInteger('review_count')->default(0);
            $table->unsignedSmallInteger('lesson_count');
            $table->decimal('rating', 2, 1)->default(0);
            $table->unsignedMediumInteger('duration')
                ->comment('Duration in seconds; max 16777215 seconds (~194 days)');

            $table->enum('level', Course::$LEVELS);
            $table->enum('status', array_keys(Course::$STATUSES));
            $table->enum('type', array_values(Course::$TYPES))->default(Course::$TYPES['free']);

            $table->foreignIdFor(Category::class);

            $table->json('skills')->nullable();
            $table->json('requirements')->nullable();
            $table->json('target_audiences')->nullable();

            $table->foreignUuid('user_id')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
