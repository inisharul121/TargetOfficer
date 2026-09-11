<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveExamController extends Controller
{
    /**
     * Show the Live Model Test Lobby with active, upcoming, and past live exams.
     */
    public function index()
    {
        $now = now();

        // 1. Currently active or today's featured Live Exams
        $liveExams = Exam::where('exam_mode', 'live_model_test')
            ->where('is_published', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('scheduled_start_at')
                  ->orWhere('scheduled_end_at', '>=', $now);
            })
            ->orderByRaw('CASE WHEN scheduled_start_at <= ? AND scheduled_end_at >= ? THEN 0 ELSE 1 END', [$now, $now])
            ->orderBy('scheduled_start_at', 'asc')
            ->withCount('questions')
            ->get();

        // 2. Completed / Past Live Exams with published national merit list
        $pastExams = Exam::where('exam_mode', 'live_model_test')
            ->where('is_published', true)
            ->where('scheduled_end_at', '<', $now)
            ->orderBy('scheduled_end_at', 'desc')
            ->withCount(['questions', 'attempts' => function ($q) {
                $q->where('status', 'completed');
            }])
            ->paginate(8);

        // 3. Current user's attempts in live exams
        $myAttemptIds = Auth::check()
            ? ExamAttempt::where('user_id', Auth::id())
                ->whereIn('exam_id', $liveExams->pluck('id')->merge($pastExams->pluck('id')))
                ->pluck('id', 'exam_id')
                ->toArray()
            : [];

        return view('live-exams.index', compact('liveExams', 'pastExams', 'myAttemptIds'));
    }

    /**
     * Real-time National Merit List and Leaderboard for a Live Exam.
     */
    public function leaderboard(Exam $exam, Request $request)
    {
        $attemptsQuery = ExamAttempt::where('exam_id', $exam->id)
            ->where('status', 'completed')
            ->with('user')
            ->orderBy('total_score', 'desc')
            ->orderBy('time_taken_seconds', 'asc');

        if ($search = $request->input('search')) {
            $attemptsQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $allAttempts = $attemptsQuery->paginate(25);

        // Calculate merit positions (including dense ranking)
        $userAttempt = null;
        $userRank = null;
        $totalParticipants = ExamAttempt::where('exam_id', $exam->id)->where('status', 'completed')->count();

        if (Auth::check()) {
            $userAttempt = ExamAttempt::where('exam_id', $exam->id)
                ->where('user_id', Auth::id())
                ->where('status', 'completed')
                ->first();

            if ($userAttempt) {
                $userRank = ExamAttempt::where('exam_id', $exam->id)
                    ->where('status', 'completed')
                    ->where(function ($q) use ($userAttempt) {
                        $q->where('total_score', '>', $userAttempt->total_score)
                          ->orWhere(function ($sub) use ($userAttempt) {
                              $sub->where('total_score', '=', $userAttempt->total_score)
                                  ->where('time_taken_seconds', '<', $userAttempt->time_taken_seconds);
                          });
                    })->count() + 1;
            }
        }

        return view('live-exams.leaderboard', compact('exam', 'allAttempts', 'userAttempt', 'userRank', 'totalParticipants'));
    }
}
