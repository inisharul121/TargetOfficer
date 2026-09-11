<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookChapter;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DigitalBookTest extends TestCase
{
    use RefreshDatabase;

    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->student = User::firstOrCreate(
            ['email' => 'candidate@targetofficer.com'],
            [
                'name' => 'BCS Candidate',
                'password' => bcrypt('password123'),
                'role' => 'candidate',
                'coins' => 50,
                'daily_streak' => 3,
            ]
        );
    }

    public function test_books_library_index_displays_all_books_and_categories(): void
    {
        $response = $this->actingAs($this->student)->get(route('books.index'));

        $response->assertStatus(200);
        $response->assertSee('বিসিএস প্রিলিমিনারি ও লিখিত ডিজিটাল বই সমগ্র');
        $response->assertSee('বিসিএস বাংলা ভাষা ও সাহিত্য');
        $response->assertSee('বিসিএস ইংরেজি ভাষা ও সাহিত্য');
        $response->assertSee('বিসিএস বাংলাদেশ বিষয়াবলী');
        $response->assertSee('বিসিএস আন্তর্জাতিক বিষয়াবলী');
        $response->assertSee('বিসিএস সাধারণ বিজ্ঞান ও তথ্যপ্রযুক্তি');
        $response->assertSee('বিসিএস গাণিতিক যুক্তি ও মানসিক দক্ষতা');
    }

    public function test_book_show_displays_chapters_and_syllabus_overview(): void
    {
        $book = Book::where('slug', 'book-bcs-bangla')->first();
        $this->assertNotNull($book);

        $response = $this->actingAs($this->student)->get(route('books.show', $book->slug));

        $response->assertStatus(200);
        $response->assertSee($book->title_bn);
        $response->assertSee('অধ্যায় ও সূচিপত্র');

        $firstChapter = $book->chapters()->first();
        $this->assertNotNull($firstChapter);
        $response->assertSee($firstChapter->title_bn);
    }

    public function test_book_read_view_renders_mcq_and_written_tabs(): void
    {
        $book = Book::where('slug', 'book-bcs-bangla')->first();
        $this->assertNotNull($book);

        // Test MCQ tab default
        $responseMcq = $this->actingAs($this->student)->get(route('books.read', [
            'slug' => $book->slug,
            'chapterNumber' => 1,
            'tab' => 'mcq'
        ]));

        $responseMcq->assertStatus(200);
        $responseMcq->assertSee('প্রিলিমিনারি MCQ অংশ');
        $responseMcq->assertSee('বিসিএস প্রিলিমিনারি বিগত বছরের প্রশ্নাবলি ও ব্যাখ্যা');

        // Test Written tab
        $responseWritten = $this->actingAs($this->student)->get(route('books.read', [
            'slug' => $book->slug,
            'chapterNumber' => 1,
            'tab' => 'written'
        ]));

        $responseWritten->assertStatus(200);
        $responseWritten->assertSee('লিখিত প্রস্তুতি ও মডেল উত্তর');
    }

    public function test_book_chapter_export_printable_views(): void
    {
        $book = Book::where('slug', 'book-bcs-english')->first();
        $this->assertNotNull($book);

        // Default export (all)
        $responseAll = $this->actingAs($this->student)->get(route('books.export', [
            'slug' => $book->slug,
            'chapterNumber' => 1,
            'mode' => 'all'
        ]));

        $responseAll->assertStatus(200);
        $responseAll->assertSee('Digital Book Series');
        $responseAll->assertSee('পর্ব ১: প্রিলিমিনারি বহুনির্বাচনী প্রশ্ন ও ব্যাখ্যা');
        $responseAll->assertSee('পর্ব ২: বিসিএস লিখিত মডেল উত্তর ও থিওরি');

        // Written-only export
        $responseWritten = $this->actingAs($this->student)->get(route('books.export', [
            'slug' => $book->slug,
            'chapterNumber' => 1,
            'mode' => 'written'
        ]));

        $responseWritten->assertStatus(200);
        $responseWritten->assertSee('পর্ব ২: বিসিএস লিখিত মডেল উত্তর ও থিওরি');
        $responseWritten->assertDontSee('পর্ব ১: প্রিলিমিনারি বহুনির্বাচনী প্রশ্ন ও ব্যাখ্যা');
    }
}
