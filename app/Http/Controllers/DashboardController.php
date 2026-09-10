<?php

namespace App\Http\Controllers;

use App\Models\AttemptAnswer;
use App\Models\Bookmark;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Organization;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $bookmarkedCount = Bookmark::where('user_id', $user->id)->count();

        // Total questions answered & mistakes
        $totalQuestionsAnswered = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
            ->where('exam_attempts.user_id', $user->id)
            ->whereNotNull('attempt_answers.is_correct')
            ->count();

        $mistakeCount = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
            ->where('exam_attempts.user_id', $user->id)
            ->where('attempt_answers.is_correct', false)
            ->distinct('attempt_answers.question_id')
            ->count('attempt_answers.question_id');

        // 1. Subject-Wise Accuracy & Performance Analytics (Student Weakness Identifier)
        $subjectPerformances = Subject::where('is_active', true)
            ->get()
            ->map(function ($subj) use ($user) {
                $totalAnswers = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
                    ->join('questions', 'attempt_answers.question_id', '=', 'questions.id')
                    ->where('exam_attempts.user_id', $user->id)
                    ->where('questions.subject_id', $subj->id)
                    ->whereNotNull('attempt_answers.is_correct')
                    ->count();

                $correctAnswers = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
                    ->join('questions', 'attempt_answers.question_id', '=', 'questions.id')
                    ->where('exam_attempts.user_id', $user->id)
                    ->where('questions.subject_id', $subj->id)
                    ->where('attempt_answers.is_correct', true)
                    ->count();

                $subj->user_accuracy = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 1) : null;
                $subj->total_answered = $totalAnswers;
                $subj->correct_count = $correctAnswers;
                $subj->wrong_count = $totalAnswers - $correctAnswers;
                return $subj;
            });

        // 2. Exam Taker / Setter Performance Breakdown (BPSC, BUET, IBA, etc.)
        $setterPerformances = Organization::where('is_question_setter', true)
            ->get()
            ->map(function ($org) use ($user) {
                $total = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
                    ->join('questions', 'attempt_answers.question_id', '=', 'questions.id')
                    ->where('exam_attempts.user_id', $user->id)
                    ->where('questions.setter_organization_id', $org->id)
                    ->whereNotNull('attempt_answers.is_correct')
                    ->count();

                $correct = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
                    ->join('questions', 'attempt_answers.question_id', '=', 'questions.id')
                    ->where('exam_attempts.user_id', $user->id)
                    ->where('questions.setter_organization_id', $org->id)
                    ->where('attempt_answers.is_correct', true)
                    ->count();

                $org->user_accuracy = $total > 0 ? round(($correct / $total) * 100, 1) : null;
                $org->total_answered = $total;
                return $org;
            });

        // 3. BCS Archives Progress (10th BCS, 11th BCS, etc.)
        $bcsArchives = Exam::with('examYear')
            ->where('exam_mode', 'previous_year')
            ->where('is_published', true)
            ->get()
            ->map(function ($exam) use ($user) {
                $bestAttempt = ExamAttempt::where('user_id', $user->id)
                    ->where('exam_id', $exam->id)
                    ->where('status', 'completed')
                    ->orderByDesc('total_score')
                    ->first();

                $exam->best_attempt = $bestAttempt;
                $exam->is_completed = !is_null($bestAttempt);
                return $exam;
            });

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
            'bookmarkedCount',
            'totalQuestionsAnswered',
            'mistakeCount',
            'subjectPerformances',
            'setterPerformances',
            'bcsArchives',
            'recommendedExams',
            'subjects'
        ));
    }
}
