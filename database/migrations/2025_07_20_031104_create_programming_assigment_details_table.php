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
        Schema::create('programming_assignment_details', static function (Blueprint $table) {
            $table->foreignIdFor(Assessment::class)->primary();
            $table->string('function_name', 50);
            $table->json('code_templates');
            $table->json('test_cases')->nullable();
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
