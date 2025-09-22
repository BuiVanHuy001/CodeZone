<?php

use App\Models\BatchEnrollments;
use App\Models\Batch;
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
        Schema::create('batch_enrollments', static function (Blueprint $table) {
			$table->id();
            $table->foreignIdFor(Batch::class)->constrained();
			$table->foreignIdFor(User::class)->constrained();
			$table->enum('status', array_keys(BatchEnrollments::$STATUSES))->default('not_started');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('batch_enrollments');
	}
};
