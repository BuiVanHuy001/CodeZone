<?php

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
        Schema::create('assessment_question_options', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->string('explanation')->nullable();
            $table->unsignedTinyInteger('position')->default(0);

	        $table->foreignIdFor(AssessmentQuestion::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_question_options');
    }
};
