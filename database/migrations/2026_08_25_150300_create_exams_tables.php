<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Exams Master Table
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title_bn');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('description_bn')->nullable();
            $table->text('description_en')->nullable();
            
            // Exam Mode
            $table->enum('exam_mode', [
                'practice',         // Untimed, immediate explanations
                'timed_mock',       // Timed standard simulation
                'live_model_test',  // Scheduled synchronized real-time exam
                'previous_year',    // Archive exam (e.g. 45th BCS)
                'daily_quiz',       // Short daily habit quiz
                'custom'            // Student-generated custom quiz
            ])->default('timed_mock');
            
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->foreignId('exam_type_id')->nullable()->constrained('exam_types')->nullOnDelete();
            $table->foreignId('exam_year_id')->nullable()->constrained('exam_years')->nullOnDelete();
            
            // Rules & Config
            $table->unsignedInteger('total_questions')->default(0);
            $table->decimal('total_marks', 6, 2)->default(0.00);
            $table->unsignedInteger('duration_minutes')->default(60); // In minutes (0 = untimed)
            $table->decimal('pass_percentage', 5, 2)->default(40.00);
            $table->decimal('negative_mark_per_question', 4, 2)->default(0.50);
            
            // Flags
            $table->boolean('is_published')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->boolean('allow_pause')->default(false); // True for practice, false for live
            $table->boolean('shuffle_questions')->default(true);
            $table->boolean('shuffle_options')->default(true);
            $table->boolean('show_instant_result')->default(true);
            
            // Scheduling for Live Model Tests
            $table->dateTime('scheduled_start_at')->nullable();
            $table->dateTime('scheduled_end_at')->nullable();
            
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['exam_mode', 'is_published']);
            $table->index(['scheduled_start_at', 'scheduled_end_at']);
        });

        // 2. Exam Sections (Optional section-wise grouping & timing)
        Schema::create('exam_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->string('name_bn');
            $table->string('name_en')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable(); // Section specific timer
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        // 3. Exam Question Links
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('exam_section_id')->nullable()->constrained('exam_sections')->nullOnDelete();
            $table->decimal('marks', 4, 2)->nullable(); // Overrides question default if set
            $table->decimal('negative_marks', 4, 2)->nullable();
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();

            $table->unique(['exam_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('exam_sections');
        Schema::dropIfExists('exams');
    }
};
