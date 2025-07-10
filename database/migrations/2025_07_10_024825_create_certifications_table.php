<?php

use App\Models\BatchEnrollments;
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
		Schema::create('certifications', function (Blueprint $table) {
			$table->id();
			$table->string('certificate_url');
			$table->string('verification_code')->unique();

			$table->foreignIdFor(User::class)->constrained();
			$table->foreignIdFor(BatchEnrollments::class)->constrained();
			$table->foreignUuid('course_id')->constrained('courses');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('certifications');
	}
};
