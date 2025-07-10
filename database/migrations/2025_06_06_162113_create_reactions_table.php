<?php

use App\Models\Reaction;
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
        Schema::create('reactions', function (Blueprint $table) {
            $table->morphs('reactable');
            $table->enum('action', Reaction::$ACTIONS);
            $table->timestamps();

	        $table->foreignIdFor(User::class)->constrained();
	        $table->primary(['user_id', 'reactable_type', 'reactable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
