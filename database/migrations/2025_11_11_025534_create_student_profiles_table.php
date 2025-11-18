<?php

use App\Models\ClassRoom;
use App\Models\Major;
use App\Models\StudentProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_profiles', static function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignIdFor(Major::class)->nullable()->constrained('majors')->nullOnDelete();

            $table->boolean('gender')->nullable()->comment('Women are true, because they are always right :)');
            $table->date('dob')->comment('Date of Birth')->nullable();

            $table->enum('student_type', array_keys(StudentProfile::$STUDENT_TYPES))->nullable();
            $table->string('student_code', 20)->nullable()->unique();
            $table->date('enrollment_year')->nullable();

            $table
                ->foreignIdFor(ClassRoom::class)
                ->nullable()
                ->constrained('class_rooms')
                ->nullOnDelete();

            $table->json('addition_data')->nullable();

            $table->mediumInteger('enrolled_count')->default(0);
            $table->mediumInteger('completed_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
