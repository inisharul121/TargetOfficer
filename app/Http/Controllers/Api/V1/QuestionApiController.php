<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Bookmark;
use App\Models\Question;
use App\Models\QuestionReport;
use Illuminate\Http\Request;

class QuestionApiController extends Controller
{
    public function practice(Request $request)
    {
        $query = Question::with(['options', 'subject', 'setterOrganization', 'tags'])
            ->where('status', 'published');

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        }

        if ($request->filled('setter_organization_id')) {
            $query->where('setter_organization_id', $request->setter_organization_id);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $questions = $query->paginate(20);

        return QuestionResource::collection($questions);
    }

    public function toggleBookmark(Request $request, Question $question)
    {
        $user = $request->user();
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

        return response()->json(['status' => 'success', 'bookmarked' => $bookmarked]);
    }

    public function report(Request $request, Question $question)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:wrong_answer,typo_error,confusing_explanation,duplicate,other',
            'comment' => 'nullable|string|max:1000',
        ]);

        $report = QuestionReport::create([
            'question_id' => $question->id,
            'user_id' => $request->user()->id,
            'report_type' => $validated['report_type'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Report submitted successfully']);
    }
}
