<?php

use App\Models\AssessmentAttempt;
use App\Models\AssessmentQuestion;
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
        Schema::create('attempt_quizzes', function (Blueprint $table) {
            $table->foreignIdFor(AssessmentAttempt::class)->primary();
            $table->smallInteger('correct_answers_count')->default(0);
            $table->smallInteger('total_questions_count')->default(0);
            $table->json('user_answers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempt_quizzes');
    }
};
