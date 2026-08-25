<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\ExamAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Top Streaks
        $streakLeaders = User::where('role', 'student')
            ->orderByDesc('daily_streak')
            ->orderByDesc('coins')
            ->take(10)
            ->get();

        // Top Exam Performers
        $examLeaders = User::select('users.*', DB::raw('AVG(exam_attempts.accuracy_percentage) as avg_accuracy'), DB::raw('COUNT(exam_attempts.id) as attempts_count'), DB::raw('SUM(exam_attempts.total_score) as total_exam_points'))
            ->join('exam_attempts', 'users.id', '=', 'exam_attempts.user_id')
            ->where('exam_attempts.status', 'completed')
            ->where('users.role', 'student')
            ->groupBy('users.id')
            ->orderByDesc('total_exam_points')
            ->take(10)
            ->get();

        $badges = Badge::all();

        return view('leaderboard.index', compact('streakLeaders', 'examLeaders', 'badges'));
    }
}
