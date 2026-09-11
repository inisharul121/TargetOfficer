<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookChapter;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display the Digital Books Library Catalog.
     */
    public function index()
    {
        $books = Book::where('is_published', true)
            ->with(['subject', 'chapters' => function ($q) {
                $q->withCount(['questions', 'writtenContents']);
            }])
            ->orderBy('order')
            ->get();

        return view('books.index', compact('books'));
    }

    /**
     * Show Book Overview & Chapters Index.
     */
    public function show(string $slug)
    {
        $book = Book::where('slug', $slug)
            ->with(['subject', 'chapters' => function ($q) {
                $q->withCount(['questions', 'writtenContents'])->orderBy('chapter_number');
            }])
            ->firstOrFail();

        return view('books.show', compact('book'));
    }

    /**
     * Interactive Smart Book Reader (MCQ + Written dual tabs).
     */
    public function read(Request $request, string $slug, int $chapterNumber = 1)
    {
        $book = Book::where('slug', $slug)
            ->with(['subject', 'chapters' => function ($q) {
                $q->withCount(['questions', 'writtenContents'])->orderBy('chapter_number');
            }])
            ->firstOrFail();

        $activeChapter = $book->chapters->firstWhere('chapter_number', $chapterNumber) 
            ?? $book->chapters->first();

        if (!$activeChapter) {
            return redirect()->route('books.index')->with('error', 'এই বইটিতে এখনও কোনো অধ্যায় যুক্ত করা হয়নি।');
        }

        // Fetch questions with options and exam tags
        $questions = $activeChapter->questions()
            ->with(['options', 'tags', 'exams.examYear'])
            ->get();

        // Fetch written materials
        $writtenContents = $activeChapter->writtenContents()
            ->orderBy('order')
            ->get();

        // Active tab mode: 'mcq' or 'written'
        $activeTab = $request->query('tab', 'mcq');
        if (!in_array($activeTab, ['mcq', 'written'])) {
            $activeTab = 'mcq';
        }

        return view('books.read', compact(
            'book',
            'activeChapter',
            'questions',
            'writtenContents',
            'activeTab'
        ));
    }

    /**
     * Export / Print a specific Book Chapter with MCQ and Written materials.
     */
    public function exportChapter(Request $request, string $slug, int $chapterNumber)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        $chapter = BookChapter::where('book_id', $book->id)
            ->where('chapter_number', $chapterNumber)
            ->firstOrFail();

        $mode = $request->query('mode', 'all'); // 'all', 'mcq', 'written'
        $questions = $chapter->questions()->with(['options', 'tags'])->get();
        $writtenContents = $chapter->writtenContents()->orderBy('order')->get();

        return view('export.pdf-book-chapter', compact(
            'book',
            'chapter',
            'questions',
            'writtenContents',
            'mode'
        ));
    }
}
