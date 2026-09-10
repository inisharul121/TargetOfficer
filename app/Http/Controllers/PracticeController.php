<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Organization;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::with('topics')->where('is_active', true)->get();
        
        $selectedSubject = null;
        $selectedTopic = null;
        $selectedExam = null;
        $selectedSetter = null;
        $selectedTag = $request->tag;

        $query = Question::with([
            'options',
            'subject',
            'setterOrganization',
            'exams.examYear',
            'tags',
        ])->where('status', 'published');

        // 1. Filter by Exam
        if ($request->filled('exam')) {
            $selectedExam = Exam::with(['examYear', 'organization'])->where('slug', $request->exam)->first();
            if ($selectedExam) {
                $query->whereHas('exams', function ($eq) use ($selectedExam) {
                    $eq->where('exams.id', $selectedExam->id);
                });
            }
        }

        // 2. Filter by Setter Organization
        if ($request->filled('setter')) {
            $selectedSetter = Organization::where('slug', $request->setter)
                ->orWhere('code', $request->setter)
                ->first();
            if ($selectedSetter) {
                $query->where('setter_organization_id', $selectedSetter->id);
            }
        }

        // 3. Filter by Tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($tq) use ($request) {
                $tq->where('tag_value', $request->tag);
            });
        }

        // 4. Filter by Subject
        if ($request->filled('subject')) {
            $selectedSubject = Subject::where('slug', $request->subject)->first();
            if ($selectedSubject) {
                $query->where('subject_id', $selectedSubject->id);

                if ($request->filled('topic')) {
                    $selectedTopic = Topic::where('slug', $request->topic)->first();
                    if ($selectedTopic) {
                        $query->where('topic_id', $selectedTopic->id);
                    }
                }
            }
        }

        // 5. Filter by Difficulty
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        // Default behavior: If no filter is applied at all, default to first subject
        if (!$request->filled('exam') && !$request->filled('setter') && !$request->filled('tag') && !$request->filled('subject')) {
            $selectedSubject = $subjects->first();
            if ($selectedSubject) {
                $query->where('subject_id', $selectedSubject->id);
            }
        }

        $questions = $query->paginate(20)->withQueryString();

        return view('practice.index', compact(
            'subjects',
            'selectedSubject',
            'selectedTopic',
            'selectedExam',
            'selectedSetter',
            'selectedTag',
            'questions'
        ));
    }
}
