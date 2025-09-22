<?php

use App\Models\AssessmentAttempt;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attempt_programmings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AssessmentAttempt::class);
            $table->text('user_code');
            $table->string('language', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempt_programmings');
    }
};
