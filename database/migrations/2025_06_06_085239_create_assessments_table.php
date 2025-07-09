<?php

use App\Models\Assessment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
	        $table->enum('type', array_values(Assessment::$TYPES))->default('quiz');
            $table->unsignedTinyInteger('questions_count')->default(1);

	        $table->foreignUuid('lesson_id')->constrained('lessons');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
