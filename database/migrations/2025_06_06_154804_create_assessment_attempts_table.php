<?php

use App\Models\Assessment;
use App\Models\User;
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
        Schema::create('assessment_attempts', static function (Blueprint $table) {
            $table->id();
            $table->boolean('is_passed')->default(false);

            $table->foreignIdFor(Assessment::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_attempts');
    }
};
