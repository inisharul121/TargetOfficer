<?php

namespace App\Http\Controllers;

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
        $questions = collect();

        if ($request->filled('subject')) {
            $selectedSubject = Subject::where('slug', $request->subject)->firstOrFail();
            
            $query = Question::with(['options', 'subject', 'setterOrganization'])
                ->where('subject_id', $selectedSubject->id)
                ->where('status', 'published');

            if ($request->filled('topic')) {
                $selectedTopic = Topic::where('slug', $request->topic)->first();
                if ($selectedTopic) {
                    $query->where('topic_id', $selectedTopic->id);
                }
            }

            if ($request->filled('difficulty')) {
                $query->where('difficulty', $request->difficulty);
            }

            $questions = $query->paginate(15)->withQueryString();
        }

        return view('practice.index', compact('subjects', 'selectedSubject', 'selectedTopic', 'questions'));
    }
}
