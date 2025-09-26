<?php

use App\Models\AssessmentAttempt;
use App\Models\QuizQuestion;
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
        Schema::create('quiz_attempts', static function (Blueprint $table) {
            $table->foreignIdFor(AssessmentAttempt::class)->primary();
            $table->smallInteger('correct_answers_count')->default(0);
            $table->smallInteger('total_questions_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
