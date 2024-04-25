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
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('commentable_id');
                $table->enum('commentable_type',  ['course', 'lesion', 'blog', 'comment']);
                $table->unsignedBigInteger('parent_comment_id')->nullable()->default(null);
                $table->foreignId('user_id')->constrained('users');
                $table->text('content');
                $table->softDeletes();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('comments');
        }
    };