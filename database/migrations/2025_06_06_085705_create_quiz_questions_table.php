<?php

use App\Models\Assessment;
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
        Schema::create('quiz_questions', static function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->enum('type', array_keys(QuizQuestion::$TYPES));
            $table->json('options')->nullable();
            $table->unsignedTinyInteger('position')->default(0);

            $table->foreignIdFor(Assessment::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
