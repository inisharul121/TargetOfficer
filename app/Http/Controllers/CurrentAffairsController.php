<?php

namespace App\Http\Controllers;

use App\Models\CurrentAffair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurrentAffairsController extends Controller
{
    /**
     * Display Monthly and Daily Current Affairs feed with category filters.
     */
    public function index(Request $request)
    {
        $categories = [
            'all' => 'সব ক্যাটাগরি',
            'bangladesh' => 'বাংলাদেশ বিষয়াবলী',
            'international' => 'আন্তর্জাতিক বিষয়াবলী',
            'economy' => 'অর্থনীতি ও বাজেট',
            'sports' => 'খেলাধুলা ও পুরস্কার',
            'science' => 'বিজ্ঞান ও প্রযুক্তি',
        ];

        $selectedCategory = $request->query('category', 'all');
        $selectedMonth = $request->query('month', '2026-09');

        $query = CurrentAffair::query();

        if ($selectedCategory !== 'all') {
            $query->where('category', $selectedCategory);
        }

        if ($selectedMonth) {
            $query->where('month_key', $selectedMonth);
        }

        $featured = (clone $query)->where('is_featured', true)->first();
        $articles = $query->orderBy('published_date', 'desc')->paginate(10);

        // Get distinct available months for archive selector
        $availableMonths = CurrentAffair::select('month_key')
            ->distinct()
            ->orderBy('month_key', 'desc')
            ->pluck('month_key')
            ->toArray();

        if (empty($availableMonths)) {
            $availableMonths = ['2026-09'];
        }

        return view('current-affairs.index', compact(
            'categories',
            'selectedCategory',
            'selectedMonth',
            'featured',
            'articles',
            'availableMonths'
        ));
    }
}
