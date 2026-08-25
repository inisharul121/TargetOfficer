<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Organizations & Question Setter Bodies
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->string('slug')->unique();
            $table->string('code', 20)->nullable()->index(); // BPSC, BUET, IBA, MIST, ARTS, BB
            $table->boolean('is_question_setter')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Exam Types
        Schema::create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 3. Exam Years / Editions
        Schema::create('exam_years', function (Blueprint $table) {
            $table->id();
            $table->string('name_en'); // e.g. "46th BCS Preliminary", "2024"
            $table->string('name_bn')->nullable();
            $table->string('year', 10)->index();
            $table->timestamps();
        });

        // 4. Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // Lucide icon or SVG code
            $table->string('color', 20)->default('#4F46E5'); // Theme accent color
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Topics
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('slug');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
            
            $table->unique(['subject_id', 'slug']);
        });

        // 6. Subtopics
        Schema::create('subtopics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();
            $table->string('name_en');
            $table->string('name_bn');
            $table->string('slug');
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subtopics');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('exam_years');
        Schema::dropIfExists('exam_types');
        Schema::dropIfExists('organizations');
    }
};
