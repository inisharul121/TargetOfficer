<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Models\UserFlashcardProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashcardController extends Controller
{
    /**
     * Flashcard Player & Deck Browser.
     */
    public function index(Request $request)
    {
        $categories = [
            'constitution' => [
                'name_bn' => 'সংবিধানের গুরুত্বপূর্ণ অনুচ্ছেদ',
                'name_en' => 'Constitution of Bangladesh',
                'icon' => '⚖️',
                'description' => 'বিসিএস প্রিলিমিনারি ও লিখিত পরীক্ষায় সংবিধানের মৌলিক অধিকার ও গুরুত্বপূর্ণ অনুচ্ছেদ।',
            ],
            'bcs_vocab' => [
                'name_bn' => 'ইংরেজি শব্দভাণ্ডার (Vocabulary)',
                'name_en' => 'BCS High-Yield Vocabulary',
                'icon' => '📖',
                'description' => 'বিগত বছরের বিসিএস ও ব্যাংক নিয়োগ পরীক্ষায় আসা সমার্থক ও বিপরীতার্থক শব্দ।',
            ],
            'bangladesh_history' => [
                'name_bn' => 'বাংলাদেশ ও মুক্তিযুদ্ধ',
                'name_en' => 'Bangladesh & Liberation War',
                'icon' => '🇧🇩',
                'description' => 'ভাষা আন্দোলন, ঐতিহাসিক ৬ দফা, ১১ দফা এবং ১৯৭১ সালের মহান মুক্তিযুদ্ধের ঘটনাবলী।',
            ],
            'math_formula' => [
                'name_bn' => 'গণিত শর্টকাট সূত্র',
                'name_en' => 'Math Formulas & Shortcuts',
                'icon' => '📐',
                'description' => 'পাটিগণিত ও বীজগণিতের গুরুত্বপূর্ণ সূত্র ও দ্রুত ক্যালকুলেশনের শর্টকাট ট্রিকস।',
            ],
        ];

        $currentCategory = $request->query('category', 'constitution');
        if (!array_key_exists($currentCategory, $categories)) {
            $currentCategory = 'constitution';
        }

        $cards = Flashcard::where('category', $currentCategory)->get();
        $user = Auth::user();

        // Get user progress
        $progressMap = [];
        if ($user) {
            $progressMap = UserFlashcardProgress::where('user_id', $user->id)
                ->whereIn('flashcard_id', $cards->pluck('id'))
                ->get()
                ->keyBy('flashcard_id');
        }

        $totalCards = $cards->count();
        $masteredCount = 0;
        foreach ($cards as $card) {
            $card->user_mastered = isset($progressMap[$card->id]) && $progressMap[$card->id]->is_mastered;
            if ($card->user_mastered) {
                $masteredCount++;
            }
        }

        $progressPercentage = $totalCards > 0 ? round(($masteredCount / $totalCards) * 100) : 0;

        return view('student.flashcards', compact(
            'categories',
            'currentCategory',
            'cards',
            'totalCards',
            'masteredCount',
            'progressPercentage'
        ));
    }

    /**
     * Mark a flashcard as Mastered or Review Again.
     */
    public function rate(Request $request, Flashcard $flashcard)
    {
        $request->validate([
            'is_mastered' => 'required|boolean',
        ]);

        $user = Auth::user();
        $isMastered = (bool)$request->is_mastered;

        $progress = UserFlashcardProgress::firstOrNew([
            'user_id' => $user->id,
            'flashcard_id' => $flashcard->id,
        ]);

        $progress->is_mastered = $isMastered;
        $progress->review_count = ($progress->review_count ?? 0) + 1;
        $progress->last_reviewed_at = now();
        $progress->save();

        if ($isMastered) {
            $user->increment('coins', 2); // 2 reward coins per mastered flashcard
        }

        return response()->json([
            'success' => true,
            'is_mastered' => $isMastered,
            'coins' => $user->coins,
        ]);
    }
}
