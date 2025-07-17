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
		Schema::create('organization_profiles', function (Blueprint $table) {
			$table->foreignIdFor(User::class)->primary();
			$table->text('bio')->nullable();
			$table->json('socials_links')->nullable();
			$table->unsignedSmallInteger('course_count')->default(0)->comment('Number of courses created by the organization and max 65535 courses');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('organization_profiles');
	}
};
