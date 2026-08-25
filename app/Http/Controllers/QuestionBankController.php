<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Organization;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionBankController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::with(['options', 'subject', 'setterOrganization', 'tags'])
            ->where('status', 'published');

        if ($request->filled('setter')) {
            $query->where('setter_organization_id', $request->setter);
        }

        if ($request->filled('subject')) {
            $query->where('subject_id', $request->subject);
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($sq) use ($term) {
                $sq->where('stem_bn', 'like', $term)
                   ->orWhere('stem_en', 'like', $term)
                   ->orWhere('explanation_bn', 'like', $term);
            });
        }

        $questions = $query->latest()->paginate(15)->withQueryString();
        $setters = Organization::where('is_question_setter', true)->get();
        $subjects = Subject::where('is_active', true)->get();

        $bookmarkedIds = Auth::check() 
            ? Bookmark::where('user_id', Auth::id())->pluck('question_id')->toArray() 
            : [];

        return view('question-bank.index', compact('questions', 'setters', 'subjects', 'bookmarkedIds'));
    }

    public function toggleBookmark(Request $request, Question $question)
    {
        $user = Auth::user();
        $existing = Bookmark::where('user_id', $user->id)->where('question_id', $question->id)->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => $user->id,
                'question_id' => $question->id,
            ]);
            $bookmarked = true;
        }

        return response()->json(['bookmarked' => $bookmarked]);
    }

    public function reportQuestion(Request $request, Question $question)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:wrong_answer,typo_error,confusing_explanation,duplicate,other',
            'comment' => 'nullable|string|max:1000',
        ]);

        QuestionReport::create([
            'question_id' => $question->id,
            'user_id' => Auth::id(),
            'report_type' => $validated['report_type'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return back()->with('success', 'আপনার রিপোর্টটি সফলভাবে গ্রহণ করা হয়েছে। ধন্যবাদ!');
    }
}
