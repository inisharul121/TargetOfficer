<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('topic_id')->nullable()->constrained('topics')->nullOnDelete();
            $table->foreignId('subtopic_id')->nullable()->constrained('subtopics')->nullOnDelete();
            $table->foreignId('setter_organization_id')->nullable()->constrained('organizations')->nullOnDelete(); // BUET, IBA, BPSC, etc.
            
            $table->text('stem_bn'); // Question body in Bangla
            $table->text('stem_en')->nullable(); // Question body in English
            $table->string('question_type')->default('single_choice'); // single_choice, multiple_choice, true_false
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            
            $table->decimal('default_marks', 4, 2)->default(1.00);
            $table->decimal('negative_marks', 4, 2)->default(0.50);
            
            $table->text('explanation_bn')->nullable(); // Rich explanation in Bangla
            $table->text('explanation_en')->nullable(); // Rich explanation in English
            $table->string('reference_source')->nullable(); // e.g. "নবম-দশম শ্রেণির বাংলা ব্যাকরণ", "BPSC Answer Key"
            
            $table->enum('status', ['draft', 'review', 'published', 'archived'])->default('published');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Analytics cache per question
            $table->unsignedInteger('times_served')->default(0);
            $table->unsignedInteger('times_correct')->default(0);
            $table->decimal('accuracy_rate', 5, 2)->default(0.00); // Cached accuracy %
            
            $table->timestamps();
            
            // Performance indexes
            $table->index(['subject_id', 'status']);
            $table->index(['setter_organization_id', 'status']);
            $table->index(['difficulty', 'status']);
        });

        // 2. Question Options
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->string('option_letter', 2); // A, B, C, D, E
            $table->text('option_text_bn');
            $table->text('option_text_en')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();

            $table->index(['question_id', 'is_correct']);
        });

        // 3. Question Multi-Tags (e.g. 45th BCS, BUET Pattern, 2023, Sonali Bank)
        Schema::create('question_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->string('tag_type', 30)->default('general'); // org, year, exam, setter, pattern, custom
            $table->string('tag_value');
            $table->timestamps();

            $table->index(['tag_type', 'tag_value']);
        });

        // 4. Candidate Question Reports (Error Reporting)
        Schema::create('question_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('report_type', ['wrong_answer', 'typo_error', 'confusing_explanation', 'duplicate', 'other'])->default('wrong_answer');
            $table->text('comment')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'resolved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_reports');
        Schema::dropIfExists('question_tags');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('questions');
    }
};
