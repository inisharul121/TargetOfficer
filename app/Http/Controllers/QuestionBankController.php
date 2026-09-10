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
        $query = Question::with(['options', 'subject', 'setterOrganization', 'tags', 'exams.examYear'])
            ->where('status', 'published');

        if ($request->filled('setter')) {
            $query->where('setter_organization_id', $request->setter);
        }

        if ($request->filled('subject')) {
            $query->where('subject_id', $request->subject);
        }

        if ($request->filled('exam')) {
            $query->whereHas('exams', function ($eq) use ($request) {
                $eq->where('slug', $request->exam);
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($tq) use ($request) {
                $tq->where('tag_value', $request->tag);
            });
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($sq) use ($term) {
                $sq->where('stem_bn', 'like', $term)
                   ->orWhere('stem_en', 'like', $term)
                   ->orWhere('explanation_bn', 'like', $term);
            });
        }

        $questions = $query->paginate(15)->withQueryString();
        $setters = Organization::where('is_question_setter', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        $exams = \App\Models\Exam::where('is_published', true)->get();

        $bookmarkedIds = Auth::check() 
            ? Bookmark::where('user_id', Auth::id())->pluck('question_id')->toArray() 
            : [];

        return view('question-bank.index', compact('questions', 'setters', 'subjects', 'exams', 'bookmarkedIds'));
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

    public function addComment(Request $request, Question $question)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'is_solution_clarification' => 'nullable|boolean',
        ]);

        $comment = \App\Models\QuestionComment::create([
            'question_id' => $question->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
            'is_solution_clarification' => $request->boolean('is_solution_clarification', false),
        ]);

        // Reward user with 5 coins for contributing solution discussions
        Auth::user()->increment('coins', 5);

        return back()->with('success', 'আপনার আলোচনা সফলভাবে যুক্ত হয়েছে এবং ৫টি রিওয়ার্ড কয়েন অর্জিত হয়েছে!');
    }

    public function upvoteComment(\App\Models\QuestionComment $comment)
    {
        $comment->increment('upvotes_count');
        return response()->json(['upvotes' => $comment->upvotes_count]);
    }
}
