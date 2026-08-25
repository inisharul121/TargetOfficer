<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamAttemptResource;
use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionResource;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamApiController extends Controller
{
    protected ExamService $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index(Request $request)
    {
        $query = Exam::with(['organization', 'examType'])->where('is_published', true);

        if ($request->filled('mode')) {
            $query->where('exam_mode', $request->mode);
        }

        $exams = $query->latest()->paginate(15);

        return ExamResource::collection($exams);
    }

    public function show(Exam $exam)
    {
        $exam->load(['organization', 'examType', 'sections']);
        return new ExamResource($exam);
    }

    public function start(Request $request, Exam $exam)
    {
        $user = $request->user();
        $attempt = $this->examService->startAttempt($user, $exam);

        $questions = $exam->questions()
            ->with(['options', 'subject', 'setterOrganization', 'tags'])
            ->get();

        return response()->json([
            'status' => 'success',
            'attempt' => new ExamAttemptResource($attempt),
            'exam' => new ExamResource($exam),
            'questions' => QuestionResource::collection($questions),
            'saved_answers' => $attempt->answers_state ?? (object)[],
        ]);
    }

    public function autoSave(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $answers = $request->input('answers', []);
        $tabSwitches = (int)$request->input('tab_switches', 0);

        $this->examService->saveProgress($attempt, $answers, $tabSwitches);

        return response()->json(['status' => 'success', 'saved_at' => now()->toIso8601String()]);
    }

    public function submit(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $answers = $request->input('answers', []);
        $timeSpent = (int)$request->input('time_spent', 0);
        $tabSwitches = (int)$request->input('tab_switches', 0);

        $completedAttempt = $this->examService->submitAttempt($attempt, $answers, $timeSpent, $tabSwitches);

        return response()->json([
            'status' => 'success',
            'result' => new ExamAttemptResource($completedAttempt),
        ]);
    }

    public function myAttempts(Request $request)
    {
        $attempts = ExamAttempt::with('exam')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return ExamAttemptResource::collection($attempts);
    }
}
