<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamAttempt;
use App\Models\Organization;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        // 1. Lowest Accuracy Questions (Tricky / High Error Rate)
        $lowestAccuracyQuestions = Question::with(['subject', 'setterOrganization'])
            ->where('times_served', '>', 0)
            ->orderBy('accuracy_rate', 'asc')
            ->take(10)
            ->get();

        // 2. Most Served Questions
        $mostServedQuestions = Question::with(['subject', 'setterOrganization'])
            ->orderByDesc('times_served')
            ->take(10)
            ->get();

        // 3. Question Setter Performance & Accuracy
        $setterAnalytics = Organization::where('is_question_setter', true)
            ->withCount('questions')
            ->get()
            ->map(function ($org) {
                $org->avg_accuracy = Question::where('setter_organization_id', $org->id)->avg('accuracy_rate') ?? 0;
                return $org;
            });

        // 4. Subject Accuracy Comparison
        $subjectAnalytics = Subject::withCount('questions')
            ->get()
            ->map(function ($sub) {
                $sub->avg_accuracy = Question::where('subject_id', $sub->id)->avg('accuracy_rate') ?? 0;
                return $sub;
            });

        // 5. Exam Performance Stats
        $totalCompletedAttempts = ExamAttempt::where('status', 'completed')->count();
        $globalAverageScore = ExamAttempt::where('status', 'completed')->avg('total_score') ?? 0;
        $globalAverageAccuracy = ExamAttempt::where('status', 'completed')->avg('accuracy_percentage') ?? 0;
        $totalTabSwitches = ExamAttempt::sum('tab_switch_count');

        return view('admin.analytics.index', compact(
            'lowestAccuracyQuestions',
            'mostServedQuestions',
            'setterAnalytics',
            'subjectAnalytics',
            'totalCompletedAttempts',
            'globalAverageScore',
            'globalAverageAccuracy',
            'totalTabSwitches'
        ));
    }
}
