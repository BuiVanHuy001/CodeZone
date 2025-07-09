<?php

use App\Models\Category;
use App\Models\Course;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('heading')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
	        $table->decimal('price', 13, 3)->default(0);
	        $table->unsignedSmallInteger('review_count')->default(0);
            $table->unsignedTinyInteger('lesson_count');
            $table->decimal('rating', 2, 1)->default(0);
            $table->unsignedSmallInteger('duration');

            $table->enum('level', Course::$LEVELS);
            $table->enum('status', Course::$STATUSES);

            $table->foreignIdFor(Category::class);

	        $table->json('skills')->nullable();
	        $table->json('requirements')->nullable();

	        $table->foreignIdFor(User::class);

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
