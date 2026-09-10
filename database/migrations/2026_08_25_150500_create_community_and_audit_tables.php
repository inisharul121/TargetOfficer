<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Question Discussion Comments (Community & Discussions)
        Schema::create('question_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('comment');
            $table->boolean('is_solution_clarification')->default(false);
            $table->unsignedInteger('upvotes_count')->default(0);
            $table->timestamps();

            $table->index(['question_id', 'created_at']);
        });

        // 2. Question Audit Logs / Version History
        Schema::create('question_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action_type', 30); // created, updated, status_changed, merged
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamps();

            $table->index(['question_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_audit_logs');
        Schema::dropIfExists('question_comments');
    }
};
