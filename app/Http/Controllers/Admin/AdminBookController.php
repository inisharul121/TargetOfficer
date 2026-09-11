<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookChapter;
use App\Models\BookWrittenContent;
use App\Models\ExamType;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBookController extends Controller
{
    /**
     * Display listing of books in Admin Panel.
     */
    public function index(Request $request)
    {
        $query = Book::with(['subject', 'examType'])
            ->withCount(['chapters', 'writtenContents']);

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', $request->is_published == '1');
        }

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($sub) use ($term) {
                $sub->where('title_bn', 'like', $term)
                    ->orWhere('title_en', 'like', $term)
                    ->orWhere('slug', 'like', $term);
            });
        }

        $books = $query->orderBy('order')->paginate(12)->withQueryString();
        $subjects = Subject::orderBy('name_bn')->get();

        return view('admin.books.index', compact('books', 'subjects'));
    }

    /**
     * Show form to create a new Digital Book.
     */
    public function create()
    {
        $subjects = Subject::orderBy('name_bn')->get();
        $examTypes = ExamType::orderBy('name_bn')->get();

        return view('admin.books.create', compact('subjects', 'examTypes'));
    }

    /**
     * Store newly created Book.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_bn' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:books,slug',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type_id' => 'nullable|exists:exam_types,id',
            'description_bn' => 'nullable|string',
            'cover_theme' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:20',
            'edition' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
            'is_premium' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $slugBase = $validated['title_en'] ?? $validated['title_bn'];
            $validated['slug'] = 'book-' . Str::slug($slugBase) . '-' . Str::random(4);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_published'] = $request->has('is_published');
        $validated['is_premium'] = $request->has('is_premium');
        $validated['order'] = $validated['order'] ?? 0;
        $validated['icon'] = $validated['icon'] ?? '📖';
        $validated['cover_theme'] = $validated['cover_theme'] ?? 'from-indigo-600 to-indigo-900';
        $validated['edition'] = $validated['edition'] ?? '১ম সংস্করণ ২০২৬';

        $book = Book::create($validated);

        return redirect()->route('admin.books.builder', $book->id)
            ->with('success', 'নতুন ডিজিটাল বই সফলভাবে তৈরি করা হয়েছে! এখন অধ্যায় ও টপিকসমূহ সাজান।');
    }

    /**
     * Show form to edit Book.
     */
    public function edit(Book $book)
    {
        $subjects = Subject::orderBy('name_bn')->get();
        $examTypes = ExamType::orderBy('name_bn')->get();

        return view('admin.books.edit', compact('book', 'subjects', 'examTypes'));
    }

    /**
     * Update existing Book.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title_bn' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'slug' => 'required|string|max:255|unique:books,slug,' . $book->id,
            'subject_id' => 'required|exists:subjects,id',
            'exam_type_id' => 'nullable|exists:exam_types,id',
            'description_bn' => 'nullable|string',
            'cover_theme' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:20',
            'edition' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['slug']);
        $validated['is_published'] = $request->has('is_published');
        $validated['is_premium'] = $request->has('is_premium');
        $validated['order'] = $validated['order'] ?? 0;

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'বইয়ের বিবরণ সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Delete Book and all nested chapters/topics.
     */
    public function destroy(Book $book)
    {
        $title = $book->title_bn;
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', "বই '{$title}' এবং এর অন্তর্ভুক্ত সকল অধ্যায় ও টপিক মুছে ফেলা হয়েছে।");
    }

    /**
     * Interactive Chapter & Topic Builder for a specific Book.
     */
    public function builder(Book $book)
    {
        $book->load([
            'subject',
            'examType',
            'chapters' => function ($q) {
                $q->orderBy('chapter_number')->with(['writtenContents' => function ($wc) {
                    $wc->orderBy('order');
                }]);
            }
        ]);

        return view('admin.books.builder', compact('book'));
    }

    /**
     * Store new Chapter in a Book.
     */
    public function storeChapter(Request $request, Book $book)
    {
        $validated = $request->validate([
            'chapter_number' => 'required|integer|min:1',
            'title_bn' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'summary_bn' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        // Check if chapter number already exists for this book
        $exists = BookChapter::where('book_id', $book->id)
            ->where('chapter_number', $validated['chapter_number'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'এই বইতে এই অধ্যায় নম্বরটি ইতোমধ্যে বিদ্যমান। ভিন্ন নম্বর নির্বাচন করুন।');
        }

        $validated['book_id'] = $book->id;
        $validated['order'] = $validated['order'] ?? $validated['chapter_number'];

        BookChapter::create($validated);

        return redirect()->route('admin.books.builder', $book->id)
            ->with('success', 'নতুন অধ্যায় সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Update an existing Chapter.
     */
    public function updateChapter(Request $request, BookChapter $chapter)
    {
        $validated = $request->validate([
            'chapter_number' => 'required|integer|min:1',
            'title_bn' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'summary_bn' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        // Check unique constraint for chapter_number within this book
        $conflict = BookChapter::where('book_id', $chapter->book_id)
            ->where('chapter_number', $validated['chapter_number'])
            ->where('id', '!=', $chapter->id)
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'এই অধ্যায় নম্বরটি এই বইয়ের অন্য একটি অধ্যায়ে ব্যবহৃত হচ্ছে।');
        }

        $chapter->update($validated);

        return redirect()->route('admin.books.builder', $chapter->book_id)
            ->with('success', 'অধ্যায় সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Delete a Chapter and its topics.
     */
    public function destroyChapter(BookChapter $chapter)
    {
        $bookId = $chapter->book_id;
        $chapter->delete();

        return redirect()->route('admin.books.builder', $bookId)
            ->with('success', 'অধ্যায় এবং এর সকল টপিক মুছে ফেলা হয়েছে।');
    }

    /**
     * Store new Topic / Written Content in a Chapter.
     */
    public function storeTopic(Request $request, BookChapter $chapter)
    {
        $validated = $request->validate([
            'title_bn' => 'required|string|max:255',
            'content_type' => 'required|in:theory_and_rules,written_question_solution,short_note,math_step_solution,essay_outline,translation',
            'question_bn' => 'nullable|string',
            'content_bn' => 'required|string',
            'marks' => 'nullable|numeric|min:0|max:100',
            'bcs_reference' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['book_chapter_id'] = $chapter->id;
        $validated['marks'] = $validated['marks'] ?? 5.0;
        $validated['order'] = $validated['order'] ?? ($chapter->writtenContents()->max('order') + 1);

        BookWrittenContent::create($validated);

        return redirect()->route('admin.books.builder', $chapter->book_id)
            ->with('success', 'নতুন পাঠ / টপিক সফলভাবে সংযুক্ত করা হয়েছে!');
    }

    /**
     * Show form to edit Topic.
     */
    public function editTopic(BookWrittenContent $topic)
    {
        $topic->load('chapter.book');
        return view('admin.books.edit-topic', compact('topic'));
    }

    /**
     * Update an existing Topic.
     */
    public function updateTopic(Request $request, BookWrittenContent $topic)
    {
        $validated = $request->validate([
            'title_bn' => 'required|string|max:255',
            'content_type' => 'required|in:theory_and_rules,written_question_solution,short_note,math_step_solution,essay_outline,translation',
            'question_bn' => 'nullable|string',
            'content_bn' => 'required|string',
            'marks' => 'nullable|numeric|min:0|max:100',
            'bcs_reference' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['marks'] = $validated['marks'] ?? 5.0;
        $validated['order'] = $validated['order'] ?? 0;

        $topic->update($validated);

        return redirect()->route('admin.books.builder', $topic->chapter->book_id)
            ->with('success', 'টপিক / পাঠের কন্টেন্ট সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Delete a Topic.
     */
    public function destroyTopic(BookWrittenContent $topic)
    {
        $bookId = $topic->chapter->book_id;
        $topic->delete();

        return redirect()->route('admin.books.builder', $bookId)
            ->with('success', 'টপিকটি সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
