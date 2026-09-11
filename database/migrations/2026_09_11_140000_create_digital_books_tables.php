<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Digital Books Table
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_type_id')->nullable()->constrained('exam_types')->nullOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->string('title_bn');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('description_bn')->nullable();
            $table->string('cover_theme')->default('from-indigo-600 to-indigo-900');
            $table->string('icon')->default('📖');
            $table->string('edition')->default('১ম সংস্করণ ২০২৬');
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->timestamps();

            $table->index(['is_published', 'order']);
        });

        // 2. Book Chapters Table
        Schema::create('book_chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('topic_id')->nullable()->constrained('topics')->nullOnDelete();
            $table->unsignedSmallInteger('chapter_number');
            $table->string('title_bn');
            $table->string('title_en')->nullable();
            $table->text('summary_bn')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->unique(['book_id', 'chapter_number']);
        });

        // 3. Book Written Materials & Model Answers (লিখিত অংশ)
        Schema::create('book_written_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_chapter_id')->constrained('book_chapters')->cascadeOnDelete();
            $table->string('title_bn');
            $table->enum('content_type', [
                'theory_and_rules',
                'written_question_solution',
                'short_note',
                'math_step_solution',
                'essay_outline',
                'translation'
            ])->default('written_question_solution');
            $table->text('question_bn')->nullable();
            $table->longText('content_bn'); // Rich HTML model answer & explanation
            $table->decimal('marks', 4, 1)->default(5.0); // e.g. 5.0 or 10.0 marks
            $table->string('bcs_reference')->nullable(); // e.g. "৩৮তম বিসিএস লিখিত"
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index(['book_chapter_id', 'content_type']);
        });

        // 4. Pivot: Questions mapped to Book Chapters
        Schema::create('book_chapter_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_chapter_id')->constrained('book_chapters')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();

            $table->unique(['book_chapter_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_chapter_questions');
        Schema::dropIfExists('book_written_contents');
        Schema::dropIfExists('book_chapters');
        Schema::dropIfExists('books');
    }
};
