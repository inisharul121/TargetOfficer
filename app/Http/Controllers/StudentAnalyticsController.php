<?php

namespace App\Http\Controllers;

use App\Models\AttemptAnswer;
use App\Models\Bookmark;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Organization;
use App\Models\Question;
use App\Models\Subject;
use App\Services\ExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAnalyticsController extends Controller
{
    protected ExamService $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    /**
     * Detailed Progress & Performance Analytics
     */
    public function progress(Request $request)
    {
        $user = Auth::user();

        // 1. Core Summary Stats
        $totalAttempts = ExamAttempt::where('user_id', $user->id)->where('status', 'completed')->count();
        $totalScore = ExamAttempt::where('user_id', $user->id)->where('status', 'completed')->avg('total_score') ?? 0;
        $overallAccuracy = ExamAttempt::where('user_id', $user->id)->where('status', 'completed')->avg('accuracy_percentage') ?? 0;

        $totalAnswersCount = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
            ->where('exam_attempts.user_id', $user->id)
            ->whereNotNull('attempt_answers.is_correct')
            ->count();

        $totalCorrectCount = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
            ->where('exam_attempts.user_id', $user->id)
            ->where('attempt_answers.is_correct', true)
            ->count();

        // 2. Subject-wise Breakdown
        $subjectPerformances = Subject::where('is_active', true)
            ->withCount('questions')
            ->get()
            ->map(function ($subj) use ($user) {
                $total = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
                    ->join('questions', 'attempt_answers.question_id', '=', 'questions.id')
                    ->where('exam_attempts.user_id', $user->id)
                    ->where('questions.subject_id', $subj->id)
                    ->whereNotNull('attempt_answers.is_correct')
                    ->count();

                $correct = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
                    ->join('questions', 'attempt_answers.question_id', '=', 'questions.id')
                    ->where('exam_attempts.user_id', $user->id)
                    ->where('questions.subject_id', $subj->id)
                    ->where('attempt_answers.is_correct', true)
                    ->count();

                $subj->total_answered = $total;
                $subj->correct_count = $correct;
                $subj->wrong_count = $total - $correct;
                $subj->accuracy = $total > 0 ? round(($correct / $total) * 100, 1) : null;
                return $subj;
            });

        // 3. Exam Taker / Setter Organization Breakdown (BPSC, BUET, IBA, etc.)
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

                $org->total_answered = $total;
                $org->correct_count = $correct;
                $org->wrong_count = $total - $correct;
                $org->accuracy = $total > 0 ? round(($correct / $total) * 100, 1) : null;
                return $org;
            });

        // 4. Past-Year BCS Exam Progress (10th BCS, 11th BCS, etc.)
        $archiveExams = Exam::with(['examYear', 'organization'])
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

        // 5. Total Mistake Questions Count
        $mistakeCount = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
            ->where('exam_attempts.user_id', $user->id)
            ->where('attempt_answers.is_correct', false)
            ->distinct('attempt_answers.question_id')
            ->count('attempt_answers.question_id');

        return view('student.progress', compact(
            'user',
            'totalAttempts',
            'totalScore',
            'overallAccuracy',
            'totalAnswersCount',
            'totalCorrectCount',
            'subjectPerformances',
            'setterPerformances',
            'archiveExams',
            'mistakeCount'
        ));
    }

    /**
     * Mistake Bank (ভুল উত্তরের ব্যাংক)
     */
    public function mistakes(Request $request)
    {
        $user = Auth::user();

        // Get IDs of all questions answered incorrectly by this user
        $mistakeSubQuery = AttemptAnswer::join('exam_attempts', 'attempt_answers.attempt_id', '=', 'exam_attempts.id')
            ->where('exam_attempts.user_id', $user->id)
            ->where('attempt_answers.is_correct', false)
            ->select('attempt_answers.question_id', \DB::raw('COUNT(*) as mistake_count'))
            ->groupBy('attempt_answers.question_id');

        $query = Question::joinSub($mistakeSubQuery, 'mistakes', function ($join) {
            $join->on('questions.id', '=', 'mistakes.question_id');
        })
        ->with(['options', 'subject', 'setterOrganization', 'exams.examYear', 'tags'])
        ->select('questions.*', 'mistakes.mistake_count');

        if ($request->filled('subject')) {
            $query->where('questions.subject_id', $request->subject);
        }

        if ($request->filled('setter')) {
            $query->where('questions.setter_organization_id', $request->setter);
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($sq) use ($term) {
                $sq->where('questions.stem_bn', 'like', $term)
                   ->orWhere('questions.explanation_bn', 'like', $term);
            });
        }

        $questions = $query->orderByDesc('mistakes.mistake_count')->paginate(15)->withQueryString();
        $subjects = Subject::where('is_active', true)->get();
        $setters = Organization::where('is_question_setter', true)->get();

        $bookmarkedIds = Bookmark::where('user_id', $user->id)->pluck('question_id')->toArray();

        return view('student.mistakes', compact('questions', 'subjects', 'setters', 'bookmarkedIds'));
    }

    /**
     * Start an Instant Exam from Mistake Bank
     */
    public function retakeMistakes(Request $request)
    {
        $user = Auth::user();
        $exam = $this->examService->generateCustomExam($user, [
            'pool_type' => 'mistakes',
            'question_count' => (int)$request->input('count', 20),
            'subject_id' => $request->input('subject_id'),
            'setter_organization_id' => $request->input('setter_organization_id'),
            'negative_marking' => 0.50,
        ]);

        return redirect()->route('exams.room', $exam->slug)->with('success', 'ভুল উত্তরের রিভিশন টেস্ট তৈরি হয়েছে! শুভকামনা।');
    }

    /**
     * Bookmarked Questions for Revision
     */
    public function bookmarks(Request $request)
    {
        $user = Auth::user();

        $query = Question::join('bookmarks', 'questions.id', '=', 'bookmarks.question_id')
            ->where('bookmarks.user_id', $user->id)
            ->with(['options', 'subject', 'setterOrganization', 'exams.examYear', 'tags'])
            ->select('questions.*', 'bookmarks.created_at as bookmarked_at');

        if ($request->filled('subject')) {
            $query->where('questions.subject_id', $request->subject);
        }

        $questions = $query->latest('bookmarks.created_at')->paginate(15)->withQueryString();
        $subjects = Subject::where('is_active', true)->get();

        $bookmarkedIds = Bookmark::where('user_id', $user->id)->pluck('question_id')->toArray();

        return view('student.bookmarks', compact('questions', 'subjects', 'bookmarkedIds'));
    }
}
