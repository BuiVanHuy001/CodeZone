<?php

use App\Models\CourseBatch;
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
            $table->string('name', 100);
            $table->string('code', 10)->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', array_keys(CourseBatch::$STATUSES))->default('upcoming');
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
