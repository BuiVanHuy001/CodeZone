<?php

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
        Schema::create('reviews', static function (Blueprint $table) {
            $table->morphs('reviewable');
            $table->text('content');
            $table->unsignedTinyInteger('rating');

	        $table->foreignIdFor(User::class)->constrained();
	        $table->primary(['user_id', 'reviewable_type', 'reviewable_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
