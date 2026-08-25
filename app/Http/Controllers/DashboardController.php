<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('badges');

        // Recent Exam Attempts
        $recentAttempts = ExamAttempt::with('exam')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Overall stats
        $totalAttemptsCount = ExamAttempt::where('user_id', $user->id)->where('status', 'completed')->count();
        $avgScore = ExamAttempt::where('user_id', $user->id)->where('status', 'completed')->avg('total_score') ?? 0;
        $avgAccuracy = ExamAttempt::where('user_id', $user->id)->where('status', 'completed')->avg('accuracy_percentage') ?? 0;

        // Recommended Exams
        $recommendedExams = Exam::with(['organization', 'examType'])
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();

        // Subjects for quick practice
        $subjects = Subject::withCount('questions')->where('is_active', true)->take(6)->get();

        return view('dashboard', compact(
            'user',
            'recentAttempts',
            'totalAttemptsCount',
            'avgScore',
            'avgAccuracy',
            'recommendedExams',
            'subjects'
        ));
    }
}
