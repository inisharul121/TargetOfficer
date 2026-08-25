<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->unique()->after('email');
            $table->string('role')->default('student')->after('phone'); // admin, setter, reviewer, student
            $table->string('target_exam')->nullable()->after('role'); // e.g. 47th BCS, Bangladesh Bank AD
            $table->string('avatar')->nullable()->after('target_exam');
            $table->unsignedInteger('coins')->default(100)->after('avatar');
            $table->unsignedInteger('daily_streak')->default(0)->after('coins');
            $table->unsignedInteger('longest_streak')->default(0)->after('daily_streak');
            $table->date('last_active_date')->nullable()->after('longest_streak');
            $table->string('preferred_language')->default('bn')->after('last_active_date'); // bn, en
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'role',
                'target_exam',
                'avatar',
                'coins',
                'daily_streak',
                'longest_streak',
                'last_active_date',
                'preferred_language',
            ]);
        });
    }
};
