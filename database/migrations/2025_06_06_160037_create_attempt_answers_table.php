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
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_correct');

            $table->foreignIdFor(AssessmentAttempt::class, 'attempt_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(AssessmentQuestion::class, 'question_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempt_answers');
    }
};
