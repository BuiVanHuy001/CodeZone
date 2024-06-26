<?php

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
            Schema::create('course_categories', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('title', 100)->unique();
                $table->string('slug', 100)->unique();
                $table->string('thumbnail', 100)->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('course_categories');
        }
    };
