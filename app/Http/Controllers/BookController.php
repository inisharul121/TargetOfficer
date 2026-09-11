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
                $q->withCount('writtenContents')->orderBy('chapter_number');
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
                $q->withCount('writtenContents')->orderBy('chapter_number');
            }])
            ->firstOrFail();

        return view('books.show', compact('book'));
    }

    /**
     * Interactive Text-Based Digital Book Reader.
     */
    public function read(Request $request, string $slug, int $chapterNumber = 1)
    {
        $book = Book::where('slug', $slug)
            ->with(['subject', 'chapters' => function ($q) {
                $q->withCount('writtenContents')->orderBy('chapter_number');
            }])
            ->firstOrFail();

        $activeChapter = $book->chapters->firstWhere('chapter_number', $chapterNumber) 
            ?? $book->chapters->first();

        if (!$activeChapter) {
            return redirect()->route('books.index')->with('error', 'এই বইটিতে এখনও কোনো অধ্যায় যুক্ত করা হয়নি।');
        }

        // Fetch text-based book contents (theories, rules, model answers, analysis)
        $writtenContents = $activeChapter->writtenContents()
            ->orderBy('order')
            ->get();

        // Previous and Next Chapters for seamless book reading
        $previousChapter = $book->chapters
            ->where('chapter_number', '<', $activeChapter->chapter_number)
            ->sortByDesc('chapter_number')
            ->first();

        $nextChapter = $book->chapters
            ->where('chapter_number', '>', $activeChapter->chapter_number)
            ->sortBy('chapter_number')
            ->first();

        return view('books.read', compact(
            'book',
            'activeChapter',
            'writtenContents',
            'previousChapter',
            'nextChapter'
        ));
    }

    /**
     * Export / Print a specific Book Chapter as a study booklet.
     */
    public function exportChapter(Request $request, string $slug, int $chapterNumber)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        $chapter = BookChapter::where('book_id', $book->id)
            ->where('chapter_number', $chapterNumber)
            ->firstOrFail();

        $writtenContents = $chapter->writtenContents()->orderBy('order')->get();

        return view('export.pdf-book-chapter', compact(
            'book',
            'chapter',
            'writtenContents'
        ));
    }
}
