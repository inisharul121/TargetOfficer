<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Weekly Study Routine & Syllabus
        Schema::create('study_routines', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('day_of_week'); // 1 = Mon, 2 = Tue, ..., 7 = Sun
            $table->string('day_name_bn'); // e.g. সোমবার
            $table->string('day_name_en'); // e.g. Monday
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();
            $table->string('topic_title_bn');
            $table->string('topic_title_en')->nullable();
            $table->text('syllabus_details_bn');
            $table->unsignedInteger('target_minutes')->default(60);
            $table->unsignedInteger('target_questions')->default(25);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. User Routine Checkmark Progress
        Schema::create('user_routine_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('study_routine_id')->constrained('study_routines')->cascadeOnDelete();
            $table->date('completed_date');
            $table->timestamps();

            $table->unique(['user_id', 'study_routine_id', 'completed_date']);
        });

        // 3. 1v1 Quiz Duel Battles
        Schema::create('quiz_duels', function (Blueprint $table) {
            $table->id();
            $table->string('duel_code', 10)->unique();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('opponent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', ['waiting', 'in_progress', 'completed'])->default('waiting');
            $table->json('question_ids'); // Array of 10 question IDs
            
            // Creator result
            $table->decimal('creator_score', 5, 2)->default(0.00);
            $table->unsignedInteger('creator_time_seconds')->default(0);
            $table->dateTime('creator_completed_at')->nullable();

            // Opponent result
            $table->decimal('opponent_score', 5, 2)->default(0.00);
            $table->unsignedInteger('opponent_time_seconds')->default(0);
            $table->dateTime('opponent_completed_at')->nullable();

            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        // 4. High-Yield Flashcards
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // bcs_vocab, constitution, bangladesh_history, math_formula, international
            $table->string('category_bn');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();
            $table->text('front_bn');
            $table->text('front_en')->nullable();
            $table->text('back_bn');
            $table->text('hint_bn')->nullable();
            $table->string('source_tag')->nullable(); // e.g. "৪৩তম বিসিএস", "সংবিধান অনুচ্ছেদ ২৭"
            $table->timestamps();

            $table->index(['category']);
        });

        // 5. User Flashcard Mastery
        Schema::create('user_flashcard_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('flashcard_id')->constrained('flashcards')->cascadeOnDelete();
            $table->boolean('is_mastered')->default(false);
            $table->unsignedInteger('review_count')->default(1);
            $table->dateTime('last_reviewed_at');
            $table->timestamps();

            $table->unique(['user_id', 'flashcard_id']);
        });

        // 6. Current Affairs & Daily GK Capsules
        Schema::create('current_affairs', function (Blueprint $table) {
            $table->id();
            $table->string('title_bn');
            $table->string('title_en')->nullable();
            $table->string('category'); // bangladesh, international, economy, sports, science
            $table->string('category_bn');
            $table->string('month_key', 7); // e.g. '2026-09'
            $table->text('summary_bn');
            $table->longText('details_bn')->nullable();
            $table->date('published_date');
            $table->boolean('is_featured')->default(false);
            $table->json('mini_quiz')->nullable(); // Mini 3-5 questions json array
            $table->timestamps();

            $table->index(['category', 'published_date']);
            $table->index(['month_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('current_affairs');
        Schema::dropIfExists('user_flashcard_progress');
        Schema::dropIfExists('flashcards');
        Schema::dropIfExists('quiz_duels');
        Schema::dropIfExists('user_routine_progress');
        Schema::dropIfExists('study_routines');
    }
};
