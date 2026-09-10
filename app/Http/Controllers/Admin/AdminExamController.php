<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamType;
use App\Models\ExamYear;
use App\Models\Organization;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['organization', 'examType', 'examYear'])->withCount('questions');

        if ($request->filled('mode')) {
            $query->where('exam_mode', $request->mode);
        }
        if ($request->filled('org_id')) {
            $query->where('organization_id', $request->org_id);
        }
        if ($request->filled('is_published')) {
            $query->where('is_published', $request->is_published == '1');
        }
        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('title_bn', 'like', $term)
                    ->orWhere('title_en', 'like', $term);
            });
        }

        $exams = $query->latest()->paginate(15)->withQueryString();
        $organizations = Organization::all();

        return view('admin.exams.index', compact('exams', 'organizations'));
    }

    public function create()
    {
        $organizations = Organization::all();
        $examTypes = ExamType::all();
        $examYears = ExamYear::latest()->get();

        return view('admin.exams.create', compact('organizations', 'examTypes', 'examYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_bn' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'exam_mode' => 'required|in:practice,timed_mock,live_model_test,previous_year,daily_quiz',
            'organization_id' => 'nullable|exists:organizations,id',
            'exam_type_id' => 'nullable|exists:exam_types,id',
            'exam_year_id' => 'nullable|exists:exam_years,id',
            'duration_minutes' => 'required|integer|min:0',
            'pass_percentage' => 'required|numeric|min:0|max:100',
            'negative_mark_per_question' => 'required|numeric|min:0',
            'description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'is_premium' => 'nullable|boolean',
            'allow_pause' => 'nullable|boolean',
            'shuffle_questions' => 'nullable|boolean',
            'shuffle_options' => 'nullable|boolean',
            'show_instant_result' => 'nullable|boolean',
            'scheduled_start_at' => 'nullable|date',
            'scheduled_end_at' => 'nullable|date|after_or_equal:scheduled_start_at',
        ]);

        $slug = Str::slug($validated['title_en'] ?? $validated['title_bn']);
        if (Exam::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(5);
        }

        $exam = Exam::create([
            'title_bn' => $validated['title_bn'],
            'title_en' => $validated['title_en'] ?? null,
            'slug' => $slug,
            'description_bn' => $validated['description_bn'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'exam_mode' => $validated['exam_mode'],
            'organization_id' => $validated['organization_id'] ?? null,
            'exam_type_id' => $validated['exam_type_id'] ?? null,
            'exam_year_id' => $validated['exam_year_id'] ?? null,
            'total_questions' => 0,
            'total_marks' => 0.00,
            'duration_minutes' => $validated['duration_minutes'],
            'pass_percentage' => $validated['pass_percentage'],
            'negative_mark_per_question' => $validated['negative_mark_per_question'],
            'is_published' => $request->boolean('is_published', true),
            'is_premium' => $request->boolean('is_premium', false),
            'allow_pause' => $request->boolean('allow_pause', false),
            'shuffle_questions' => $request->boolean('shuffle_questions', true),
            'shuffle_options' => $request->boolean('shuffle_options', true),
            'show_instant_result' => $request->boolean('show_instant_result', true),
            'scheduled_start_at' => $validated['scheduled_start_at'] ?? null,
            'scheduled_end_at' => $validated['scheduled_end_at'] ?? null,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.exams.builder', $exam->id)->with('success', 'পরীক্ষা তৈরি হয়েছে! এবার প্রশ্ন যোগ করুন।');
    }

    public function edit(Exam $exam)
    {
        $organizations = Organization::all();
        $examTypes = ExamType::all();
        $examYears = ExamYear::latest()->get();

        return view('admin.exams.edit', compact('exam', 'organizations', 'examTypes', 'examYears'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title_bn' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'exam_mode' => 'required|in:practice,timed_mock,live_model_test,previous_year,daily_quiz',
            'organization_id' => 'nullable|exists:organizations,id',
            'exam_type_id' => 'nullable|exists:exam_types,id',
            'exam_year_id' => 'nullable|exists:exam_years,id',
            'duration_minutes' => 'required|integer|min:0',
            'pass_percentage' => 'required|numeric|min:0|max:100',
            'negative_mark_per_question' => 'required|numeric|min:0',
            'description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'scheduled_start_at' => 'nullable|date',
            'scheduled_end_at' => 'nullable|date|after_or_equal:scheduled_start_at',
        ]);

        $exam->update([
            'title_bn' => $validated['title_bn'],
            'title_en' => $validated['title_en'] ?? null,
            'description_bn' => $validated['description_bn'] ?? null,
            'description_en' => $validated['description_en'] ?? null,
            'exam_mode' => $validated['exam_mode'],
            'organization_id' => $validated['organization_id'] ?? null,
            'exam_type_id' => $validated['exam_type_id'] ?? null,
            'exam_year_id' => $validated['exam_year_id'] ?? null,
            'duration_minutes' => $validated['duration_minutes'],
            'pass_percentage' => $validated['pass_percentage'],
            'negative_mark_per_question' => $validated['negative_mark_per_question'],
            'is_published' => $request->boolean('is_published', true),
            'is_premium' => $request->boolean('is_premium', false),
            'allow_pause' => $request->boolean('allow_pause', false),
            'shuffle_questions' => $request->boolean('shuffle_questions', true),
            'shuffle_options' => $request->boolean('shuffle_options', true),
            'show_instant_result' => $request->boolean('show_instant_result', true),
            'scheduled_start_at' => $validated['scheduled_start_at'] ?? null,
            'scheduled_end_at' => $validated['scheduled_end_at'] ?? null,
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'পরীক্ষার তথ্য সফলভাবে আপডেট হয়েছে!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'পরীক্ষা সফলভাবে মুছে ফেলা হয়েছে।');
    }

    public function builder(Request $request, Exam $exam)
    {
        $exam->load(['questions.options', 'questions.subject', 'questions.setterOrganization', 'organization']);

        // Search in question bank to attach
        $attachedIds = $exam->questions->pluck('id')->toArray();
        $query = Question::with(['subject', 'setterOrganization', 'options'])
            ->where('status', 'published')
            ->whereNotIn('id', $attachedIds);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('setter_id')) {
            $query->where('setter_organization_id', $request->setter_id);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }
        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('stem_bn', 'like', $term)
                    ->orWhere('stem_en', 'like', $term);
            });
        }

        $availableQuestions = $query->latest()->paginate(15)->withQueryString();
        $subjects = Subject::all();
        $setters = Organization::where('is_question_setter', true)->get();

        return view('admin.exams.builder', compact('exam', 'availableQuestions', 'subjects', 'setters'));
    }

    public function attachQuestion(Request $request, Exam $exam)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'marks' => 'nullable|numeric|min:0.25',
            'negative_marks' => 'nullable|numeric|min:0',
        ]);

        $question = Question::findOrFail($request->question_id);

        if (!$exam->questions()->where('question_id', $question->id)->exists()) {
            $maxOrder = $exam->questions()->count();
            ExamQuestion::create([
                'exam_id' => $exam->id,
                'question_id' => $question->id,
                'marks' => $request->marks ?? $question->default_marks,
                'negative_marks' => $request->negative_marks ?? $question->negative_marks,
                'order' => $maxOrder + 1,
            ]);

            $this->syncExamMetrics($exam);
        }

        return back()->with('success', 'প্রশ্নটি পরীক্ষায় সফলভাবে সংযুক্ত করা হয়েছে!');
    }

    public function detachQuestion(Exam $exam, Question $question)
    {
        $exam->questions()->detach($question->id);
        $this->syncExamMetrics($exam);

        return back()->with('success', 'প্রশ্নটি পরীক্ষা থেকে অপসারিত হয়েছে!');
    }

    public function autoAssignQuestions(Request $request, Exam $exam)
    {
        $request->validate([
            'subject_id' => 'nullable|exists:subjects,id',
            'setter_id' => 'nullable|exists:organizations,id',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'count' => 'required|integer|min:1|max:100',
        ]);

        $attachedIds = $exam->questions()->pluck('questions.id')->toArray();
        $query = Question::where('status', 'published')->whereNotIn('id', $attachedIds);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        if ($request->filled('setter_id')) {
            $query->where('setter_organization_id', $request->setter_id);
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $pickedQuestions = $query->inRandomOrder()->take((int)$request->count)->get();

        if ($pickedQuestions->isEmpty()) {
            return back()->withErrors(['count' => 'প্রদত্ত ফিল্টার অনুযায়ী কোনো নতুন প্রশ্ন পাওয়া যায়নি।']);
        }

        $currentOrder = $exam->questions()->count();
        foreach ($pickedQuestions as $pq) {
            $currentOrder++;
            ExamQuestion::create([
                'exam_id' => $exam->id,
                'question_id' => $pq->id,
                'marks' => $pq->default_marks,
                'negative_marks' => $pq->negative_marks,
                'order' => $currentOrder,
            ]);
        }

        $this->syncExamMetrics($exam);

        return back()->with('success', "সফলভাবে {$pickedQuestions->count()} টি প্রশ্ন স্বয়ংক্রিয়ভাবে পরীক্ষায় সংযুক্ত করা হয়েছে!");
    }

    private function syncExamMetrics(Exam $exam): void
    {
        $totalQuestions = $exam->questions()->count();
        $totalMarks = $exam->questions()->sum('exam_questions.marks') ?? $totalQuestions;

        $exam->update([
            'total_questions' => $totalQuestions,
            'total_marks' => $totalMarks,
        ]);
    }
}
