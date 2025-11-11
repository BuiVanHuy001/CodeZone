<?php

use App\Models\Course;
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
        Schema::create('batch_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Course::class)->constrained('courses')->cascadeOnDelete();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', CourseBatch::$STATUSES)->default('upcoming');
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
