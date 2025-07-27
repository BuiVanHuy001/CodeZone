<?php

use App\Models\Lesson;
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
        Schema::create('tracking_progresses', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_completed')->default(false);
	        $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Lesson::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_progresses');
    }
};
