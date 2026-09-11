<?php

namespace App\Http\Controllers;

use App\Models\StudyRoutine;
use App\Models\UserRoutineProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyRoutineController extends Controller
{
    /**
     * Display the Weekly BCS & Job Preparation Syllabus Planner.
     */
    public function index()
    {
        $routines = StudyRoutine::with('subject')
            ->where('is_active', true)
            ->orderBy('day_of_week')
            ->get();

        $todayDayOfWeek = now()->dayOfWeekIso; // 1 (Mon) - 7 (Sun)
        $todayDate = now()->toDateString();

        // Fetch user's completed routines for the current week
        $startOfWeek = now()->startOfWeek()->toDateString();
        $endOfWeek = now()->endOfWeek()->toDateString();

        $completedRoutineIds = [];
        if (Auth::check()) {
            $completedRoutineIds = UserRoutineProgress::where('user_id', Auth::id())
                ->whereBetween('completed_date', [$startOfWeek, $endOfWeek])
                ->pluck('study_routine_id')
                ->toArray();
        }

        $totalRoutines = $routines->count();
        $completedCount = count($completedRoutineIds);
        $completionPercentage = $totalRoutines > 0 ? round(($completedCount / $totalRoutines) * 100) : 0;

        return view('student.routine', compact(
            'routines',
            'todayDayOfWeek',
            'todayDate',
            'completedRoutineIds',
            'totalRoutines',
            'completedCount',
            'completionPercentage'
        ));
    }

    /**
     * Toggle completion status of a routine topic for the current user.
     */
    public function toggle(StudyRoutine $routine)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $progress = UserRoutineProgress::where('user_id', $user->id)
            ->where('study_routine_id', $routine->id)
            ->where('completed_date', $today)
            ->first();

        if ($progress) {
            $progress->delete();
            $completed = false;
            $message = 'সিলেবাস টপিকটি অসম্পূর্ণ হিসেবে চিহ্নিত করা হয়েছে।';
        } else {
            UserRoutineProgress::create([
                'user_id' => $user->id,
                'study_routine_id' => $routine->id,
                'completed_date' => $today,
            ]);
            $completed = true;
            // Reward 5 coins for completing routine study
            $user->increment('coins', 5);
            $message = 'অভিনন্দন! আপনি আজকের টপিক সম্পন্ন করেছেন (+৫ কয়েন অর্জিত)!';
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'completed' => $completed,
                'message' => $message,
                'coins' => $user->coins,
            ]);
        }

        return back()->with('success', $message);
    }
}
