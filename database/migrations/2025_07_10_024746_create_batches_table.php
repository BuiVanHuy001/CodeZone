<?php

use App\Models\Course;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
        Schema::create('batches', static function (Blueprint $table) {
			$table->id();
			$table->datetime('start_at');
			$table->datetime('end_at')->nullable();
            $table->foreignIdFor(Course::class)->constrained();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('batches');
	}
};
