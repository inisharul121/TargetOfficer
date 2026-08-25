<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Exam Attempts
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            
            $table->enum('status', ['in_progress', 'completed', 'timed_out', 'abandoned'])->default('in_progress');
            
            // Scoring
            $table->decimal('total_score', 6, 2)->default(0.00);
            $table->unsignedSmallInteger('total_correct')->default(0);
            $table->unsignedSmallInteger('total_incorrect')->default(0);
            $table->unsignedSmallInteger('total_unanswered')->default(0);
            $table->decimal('total_negative_marks', 5, 2)->default(0.00);
            $table->decimal('accuracy_percentage', 5, 2)->default(0.00);
            $table->decimal('percentile_rank', 5, 2)->nullable();
            
            // Timing & Anti-Cheat
            $table->unsignedInteger('time_taken_seconds')->default(0);
            $table->dateTime('started_at');
            $table->dateTime('completed_at')->nullable();
            $table->unsignedSmallInteger('tab_switch_count')->default(0); // Focus loss anti-cheat counter
            
            // Offline/Reload Recovery State
            $table->json('answers_state')->nullable(); // Snapshot of current answers
            
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['exam_id', 'status', 'total_score']);
        });

        // 2. Individual Attempt Answer Details
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('exam_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            
            $table->foreignId('selected_option_id')->nullable()->constrained('question_options')->nullOnDelete();
            $table->boolean('is_correct')->nullable();
            $table->decimal('marks_awarded', 4, 2)->default(0.00);
            $table->unsignedSmallInteger('time_spent_seconds')->default(0);
            $table->boolean('is_marked_for_review')->default(false);
            
            $table->timestamps();

            $table->unique(['attempt_id', 'question_id']);
        });

        // 3. Question Bookmarks / Saved Questions
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'question_id']);
        });

        // 4. Badges (Gamification)
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');
            $table->string('name_en');
            $table->string('code', 50)->unique(); // e.g. FIRST_EXAM, STREAK_7_DAYS, BCS_MASTER
            $table->string('icon')->nullable();
            $table->text('description_bn');
            $table->unsignedInteger('reward_coins')->default(50);
            $table->timestamps();
        });

        // 5. User Badges
        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained('badges')->cascadeOnDelete();
            $table->dateTime('awarded_at');
            $table->timestamps();

            $table->unique(['user_id', 'badge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('attempt_answers');
        Schema::dropIfExists('exam_attempts');
    }
};
