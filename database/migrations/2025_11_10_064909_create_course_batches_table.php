<?php

use App\Models\BatchEnrollment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', array_keys(BatchEnrollment::$STATUSES))->default('not_started');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_batches');
    }
};
