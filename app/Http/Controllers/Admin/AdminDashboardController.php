<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Organization;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\Subject;
use App\Models\User;
use App\Models\Book;
use App\Models\BookChapter;
use App\Models\BookWrittenContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Platform Metric Totals
        $totalQuestions = Question::count();
        $publishedQuestions = Question::where('status', 'published')->count();
        $draftQuestions = Question::where('status', 'draft')->count();
        $reviewQuestions = Question::where('status', 'review')->count();

        $totalExams = Exam::count();
        $publishedExams = Exam::where('is_published', true)->count();
        $liveModelTests = Exam::where('exam_mode', 'live_model_test')->count();

        $totalCandidates = User::where('role', 'student')->count();
        $totalStaff = User::whereIn('role', ['admin', 'setter', 'reviewer'])->count();

        $totalAttempts = ExamAttempt::count();
        $completedAttempts = ExamAttempt::where('status', 'completed')->count();
        $todayAttempts = ExamAttempt::whereDate('created_at', now()->toDateString())->count();

        $pendingReports = QuestionReport::where('status', 'pending')->count();

        // Setter Distribution (BUET, IBA, BPSC, Arts, MIST etc.)
        $setterStats = Organization::where('is_question_setter', true)
            ->withCount('questions')
            ->orderByDesc('questions_count')
            ->get();

        // Subject Breakdown
        $subjectStats = Subject::withCount('questions')
            ->orderByDesc('questions_count')
            ->get();

        // Digital Books & Topics Metric
        $totalBooks = Book::count();
        $totalChapters = BookChapter::count();
        $totalTopics = BookWrittenContent::count();

        // Recent Attempts
        $recentAttempts = ExamAttempt::with(['user', 'exam'])
            ->latest()
            ->take(8)
            ->get();

        // Recent Error Reports
        $recentReports = QuestionReport::with(['question', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalQuestions',
            'publishedQuestions',
            'draftQuestions',
            'reviewQuestions',
            'totalExams',
            'publishedExams',
            'liveModelTests',
            'totalCandidates',
            'totalStaff',
            'totalAttempts',
            'completedAttempts',
            'todayAttempts',
            'pendingReports',
            'totalBooks',
            'totalChapters',
            'totalTopics',
            'setterStats',
            'subjectStats',
            'recentAttempts',
            'recentReports'
        ));
    }
}
