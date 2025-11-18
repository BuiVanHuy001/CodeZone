<?php

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
        Schema::create('certifications', static function (Blueprint $table) {
			$table->id();
			$table->string('certificate_url');
			$table->string('verification_code')->unique();

            $table->foreignUuid(User::class)->constrained('users');
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
