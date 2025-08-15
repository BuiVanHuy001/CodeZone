<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->primary();

            $table->boolean('gender')->comment('men are false because women are always true :))')->nullable();
            $table->mediumInteger('enrolled_count')->default(0);
            $table->mediumInteger('completed_count')->default(0);
            $table->date('dob')->comment('Date of Birth')->nullable();
            $table->json('addition_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
