<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuizDuel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizDuelController extends Controller
{
    /**
     * Duel Lobby: create a new battle or join with a code.
     */
    public function index()
    {
        $subjects = Subject::where('is_active', true)->get();
        $user = Auth::user();

        // My recent duels
        $myDuels = QuizDuel::where(function ($q) use ($user) {
                $q->where('creator_id', $user->id)
                  ->orWhere('opponent_id', $user->id);
            })
            ->with(['creator', 'opponent', 'winner', 'subject'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Active open duels looking for opponents
        $openDuels = QuizDuel::where('status', 'waiting')
            ->where('creator_id', '!=', $user->id)
            ->with(['creator', 'subject'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('duel.index', compact('subjects', 'myDuels', 'openDuels'));
    }

    /**
     * Create a new 10-question duel challenge.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        $query = Question::where('status', 'published');
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $questionIds = $query->inRandomOrder()->take(10)->pluck('id')->toArray();

        // If not enough questions in subject, fall back to all published questions
        if (count($questionIds) < 10) {
            $questionIds = Question::where('status', 'published')
                ->inRandomOrder()
                ->take(10)
                ->pluck('id')
                ->toArray();
        }

        $code = 'DUEL-' . strtoupper(Str::random(5));

        $duel = QuizDuel::create([
            'duel_code' => $code,
            'subject_id' => $request->subject_id,
            'creator_id' => Auth::id(),
            'status' => 'waiting',
            'question_ids' => $questionIds,
        ]);

        return redirect()->route('battle.arena', $duel->duel_code);
    }

    /**
     * Join an existing duel by code.
     */
    public function join(Request $request)
    {
        $request->validate([
            'duel_code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->duel_code));
        $duel = QuizDuel::where('duel_code', $code)->firstOrFail();

        $user = Auth::user();
        if ($duel->creator_id !== $user->id && !$duel->opponent_id) {
            $duel->update([
                'opponent_id' => $user->id,
                'status' => 'in_progress',
            ]);
        }

        return redirect()->route('battle.arena', $duel->duel_code);
    }

    /**
     * Duel Arena: taking the 10-question rapid quiz.
     */
    public function arena(string $code)
    {
        $duel = QuizDuel::where('duel_code', strtoupper($code))
            ->with(['creator', 'opponent', 'subject'])
            ->firstOrFail();

        $user = Auth::user();

        // Check if user is participant
        if ($duel->creator_id !== $user->id && $duel->opponent_id !== $user->id) {
            if (!$duel->opponent_id && $duel->status === 'waiting') {
                $duel->update([
                    'opponent_id' => $user->id,
                    'status' => 'in_progress',
                ]);
            } else {
                return redirect()->route('battle.result', $duel->duel_code)
                    ->with('error', 'এই কুইজ ব্যাটেলটিতে ইতোমধ্যে দুজন প্রতিযোগী অংশগ্রহণ করেছেন।');
            }
        }

        // If current user already submitted, go straight to result
        if (($duel->creator_id === $user->id && $duel->creator_completed_at) ||
            ($duel->opponent_id === $user->id && $duel->opponent_completed_at)) {
            return redirect()->route('battle.result', $duel->duel_code);
        }

        $questions = Question::whereIn('id', $duel->question_ids)
            ->with('options')
            ->get();

        return view('duel.arena', compact('duel', 'questions'));
    }

    /**
     * Submit duel answers and evaluate.
     */
    public function submit(Request $request, string $code)
    {
        $duel = QuizDuel::where('duel_code', strtoupper($code))->firstOrFail();
        $user = Auth::user();

        $answers = $request->input('answers', []);
        $timeTaken = min(300, max(5, (int)$request->input('time_taken_seconds', 60)));

        $questions = Question::whereIn('id', $duel->question_ids)->with('options')->get();

        $score = 0.00;
        foreach ($questions as $q) {
            $selectedOptionId = $answers[$q->id] ?? null;
            if ($selectedOptionId) {
                $correctOpt = $q->options->firstWhere('is_correct', true);
                if ($correctOpt && (int)$selectedOptionId === (int)$correctOpt->id) {
                    $score += 1.0;
                } else {
                    $score -= 0.50; // 0.5 negative marking
                }
            }
        }
        $score = max(0.00, $score);

        if ($duel->creator_id === $user->id) {
            $duel->creator_score = $score;
            $duel->creator_time_seconds = $timeTaken;
            $duel->creator_completed_at = now();
        } elseif ($duel->opponent_id === $user->id) {
            $duel->opponent_score = $score;
            $duel->opponent_time_seconds = $timeTaken;
            $duel->opponent_completed_at = now();
        }

        // Check if both have completed
        if ($duel->creator_completed_at && $duel->opponent_completed_at) {
            $duel->status = 'completed';

            if ($duel->creator_score > $duel->opponent_score) {
                $duel->winner_id = $duel->creator_id;
            } elseif ($duel->opponent_score > $duel->creator_score) {
                $duel->winner_id = $duel->opponent_id;
            } else {
                // Score tie: faster player wins!
                $duel->winner_id = ($duel->creator_time_seconds <= $duel->opponent_time_seconds)
                    ? $duel->creator_id
                    : $duel->opponent_id;
            }

            // Reward winner with 25 coins
            if ($winner = \App\Models\User::find($duel->winner_id)) {
                $winner->increment('coins', 25);
            }
        }

        $duel->save();

        return redirect()->route('battle.result', $duel->duel_code);
    }

    /**
     * Duel Result & Head-to-Head Comparison Screen.
     */
    public function result(string $code)
    {
        $duel = QuizDuel::where('duel_code', strtoupper($code))
            ->with(['creator', 'opponent', 'winner', 'subject'])
            ->firstOrFail();

        $questions = Question::whereIn('id', $duel->question_ids)->with('options')->get();

        return view('duel.result', compact('duel', 'questions'));
    }
}
