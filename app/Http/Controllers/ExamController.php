<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Organization;
use App\Models\Question;
use App\Models\Subject;
use App\Services\ExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    protected ExamService $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index(Request $request)
    {
        $query = Exam::with(['organization', 'examType', 'examYear'])
            ->where('is_published', true);

        if ($request->filled('mode')) {
            $query->where('exam_mode', $request->mode);
        }

        if ($request->filled('org')) {
            $query->where('organization_id', $request->org);
        }

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title_bn', 'like', $term)
                  ->orWhere('title_en', 'like', $term)
                  ->orWhere('description_bn', 'like', $term);
            });
        }

        $exams = $query->latest()->paginate(12)->withQueryString();
        $organizations = Organization::all();

        return view('exams.index', compact('exams', 'organizations'));
    }

    public function show(Exam $exam)
    {
        $exam->load(['organization', 'examType', 'examYear']);
        
        $userAttempt = null;
        if (Auth::check()) {
            $userAttempt = ExamAttempt::where('user_id', Auth::id())
                ->where('exam_id', $exam->id)
                ->latest()
                ->first();
        }

        return view('exams.show', compact('exam', 'userAttempt'));
    }

    public function room(Exam $exam)
    {
        $user = Auth::user();
        $attempt = $this->examService->startAttempt($user, $exam);

        if ($attempt->status === 'completed') {
            return redirect()->route('exams.result', $attempt->id);
        }

        // Load exam questions with options and subjects
        $questions = $exam->questions()
            ->with(['options', 'subject', 'setterOrganization'])
            ->get();

        // Calculate remaining seconds if timed
        $durationSeconds = $exam->duration_minutes * 60;
        $elapsedSeconds = $attempt->started_at ? now()->diffInSeconds($attempt->started_at) : 0;
        $remainingSeconds = max(0, $durationSeconds - $elapsedSeconds);

        return view('exams.room', [
            'exam' => $exam,
            'attempt' => $attempt,
            'questions' => $questions,
            'remainingSeconds' => $exam->duration_minutes > 0 ? $remainingSeconds : 0,
            'savedAnswers' => $attempt->answers_state ?? [],
        ]);
    }

    public function saveState(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $answers = $request->input('answers', []);
        $tabSwitches = (int)$request->input('tab_switches', 0);

        $this->examService->saveProgress($attempt, $answers, $tabSwitches);

        return response()->json(['status' => 'success', 'saved_at' => now()->toTimeString()]);
    }

    public function submit(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        $answers = $request->input('answers', []);
        $timeSpent = (int)$request->input('time_spent', 0);
        $tabSwitches = (int)$request->input('tab_switches', 0);

        $completedAttempt = $this->examService->submitAttempt($attempt, $answers, $timeSpent, $tabSwitches);

        return redirect()->route('exams.result', $completedAttempt->id)->with('success', 'পরীক্ষা সফলভাবে জমা দেওয়া হয়েছে!');
    }

    public function result(ExamAttempt $attempt)
    {
        if ($attempt->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $attempt->load(['exam.organization', 'answers.question.options', 'answers.question.subject', 'answers.question.setterOrganization']);

        // Rank in this exam
        $totalTestTakers = ExamAttempt::where('exam_id', $attempt->exam_id)->where('status', 'completed')->count();
        $rank = ExamAttempt::where('exam_id', $attempt->exam_id)
            ->where('status', 'completed')
            ->where('total_score', '>', $attempt->total_score)
            ->count() + 1;

        return view('exams.result', compact('attempt', 'totalTestTakers', 'rank'));
    }

    public function createCustom()
    {
        $subjects = Subject::where('is_active', true)->with('topics')->get();
        $setters = Organization::where('is_question_setter', true)->get();

        return view('exams.custom', compact('subjects', 'setters'));
    }

    public function storeCustom(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'nullable|exists:subjects,id',
            'topic_id' => 'nullable|exists:topics,id',
            'setter_organization_id' => 'nullable|exists:organizations,id',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'question_count' => 'required|integer|min:5|max:50',
        ]);

        $customExam = $this->examService->generateCustomExam(Auth::user(), $validated);

        return redirect()->route('exams.room', $customExam->slug);
    }
}
