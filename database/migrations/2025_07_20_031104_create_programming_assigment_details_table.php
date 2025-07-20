<?php

use App\Models\Assessment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programming_assignment_details', function (Blueprint $table) {
            $table->foreignIdFor(Assessment::class)->primary();
            $table->json('problem_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programming_assignment_details');
    }
};
