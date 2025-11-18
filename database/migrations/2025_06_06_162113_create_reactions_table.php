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
        Schema::create('reactions', static function (Blueprint $table) {
            $table->id();
            $table->uuidMorphs('reactionable');
            $table->enum('action', Reaction::$ACTIONS);
            $table->timestamps();

            $table->foreignUuid('user_id')->constrained('users');
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
