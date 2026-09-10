<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'global');
        $orgId = $request->get('org_id');

        // 1. Top Exam Performers Query
        $query = User::select(
            'users.*',
            DB::raw('AVG(exam_attempts.accuracy_percentage) as avg_accuracy'),
            DB::raw('COUNT(exam_attempts.id) as attempts_count'),
            DB::raw('SUM(exam_attempts.total_score) as total_exam_points')
        )
        ->join('exam_attempts', 'users.id', '=', 'exam_attempts.user_id')
        ->join('exams', 'exam_attempts.exam_id', '=', 'exams.id')
        ->where('exam_attempts.status', 'completed')
        ->where('users.role', 'student');

        if ($tab === 'org' && $orgId) {
            $query->where('exams.organization_id', $orgId);
        }

        $examLeaders = $query->groupBy('users.id')
            ->orderByDesc('total_exam_points')
            ->take(15)
            ->get();

        // 2. Top Streaks
        $streakLeaders = User::where('role', 'student')
            ->orderByDesc('daily_streak')
            ->orderByDesc('coins')
            ->take(12)
            ->get();

        $organizations = Organization::where('is_question_setter', true)->get();
        $badges = Badge::all();

        return view('leaderboard.index', compact('streakLeaders', 'examLeaders', 'badges', 'organizations', 'tab', 'orgId'));
    }
}
