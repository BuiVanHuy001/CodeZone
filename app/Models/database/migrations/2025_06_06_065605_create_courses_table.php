<?php

namespace App\Models\database\migrations;

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
		Schema::create('courses', function (Blueprint $table) {
			$table->uuid('id')->primary();

			$table->string('title');
			$table->string('slug')->unique();
			$table->string('thumbnail')->nullable();
			$table->text('description')->nullable();
			$table->enum('status', Course::$STATUSES)->default('pending');
			$table->enum('level', Course::$LEVELS);
			$table->decimal('price', 10, 3)->default(0);
			$table->decimal('discount_price', 10, 3)->default(0);
			$table->unsignedSmallInteger('duration')->default(0);
			$table->unsignedSmallInteger('total_lessons')->default(0);
			$table->unsignedSmallInteger('total_students')->default(0);
			$table->unsignedSmallInteger('total_reviews')->default(0);
			$table->decimal('rating', 2, 1)->default(0);
			$table->json('skills');
			$table->json('requirements');
			wss);
			$table->foreignIdFor(User::class);

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
