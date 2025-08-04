<?php

use App\Models\OrganizationUser;
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
		Schema::create('organization_users', function (Blueprint $table) {
			$table->foreignIdFor(User::class)->constrained();
			$table->foreignIdFor(User::class, 'organization_id')->constrained();
			$table->primary(['user_id', 'organization_id']);

			$table->enum('status', array_keys(OrganizationUser::$STATUSES))->default('active');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('organization_users');
	}
};
