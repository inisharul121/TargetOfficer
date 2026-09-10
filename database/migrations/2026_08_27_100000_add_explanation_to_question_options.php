<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('question_options', function (Blueprint $table) {
            // Per-option rationale: "why this option is correct/incorrect" or "distractor logic"
            $table->text('explanation_bn')->nullable()->after('is_correct');
            $table->text('explanation_en')->nullable()->after('explanation_bn');
        });
    }

    public function down(): void
    {
        Schema::table('question_options', function (Blueprint $table) {
            $table->dropColumn(['explanation_bn', 'explanation_en']);
        });
    }
};