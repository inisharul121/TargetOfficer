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
        $response->assertSee('বিসিএস বিষয়ভিত্তিক টেক্সট ই-বুক সমগ্র');
        $response->assertSee('বিসিএস বাংলা ভাষা ও সাহিত্য সমগ্র');
        $response->assertSee('বিসিএস ইংরেজি ভাষা ও সাহিত্য সমগ্র');
        $response->assertSee('বিসিএস বাংলাদেশ বিষয়াবলী সমগ্র');
        $response->assertSee('বিসিএস আন্তর্জাতিক বিষয়াবলী সমগ্র');
        $response->assertSee('বিসিএস সাধারণ বিজ্ঞান ও তথ্যপ্রযুক্তি সমগ্র');
        $response->assertSee('বিসিএস গাণিতিক যুক্তি ও মানসিক দক্ষতা সমগ্র');
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

    public function test_book_read_view_renders_clean_text_ebook_without_mcq_options(): void
    {
        $book = Book::where('slug', 'book-bcs-bangla')->first();
        $this->assertNotNull($book);

        $response = $this->actingAs($this->student)->get(route('books.read', [
            'slug' => $book->slug,
            'chapterNumber' => 1
        ]));

        $response->assertStatus(200);
        // Rich text content verified
        $response->assertSee('অধ্যায় ১: বাংলা ব্যাকরণ, ধ্বনিতত্ত্ব ও বানান রীতি');
        $response->assertSee('ধ্বনি ও বর্ণের সংজ্ঞা এবং মৌলিক পার্থক্য');
        $response->assertSee('ণ-ত্ব বিধান ও বাংলা বানানে এর নিয়মাবলী');
        $response->assertSee('বাংলা একাডেমি প্রমিত বানান রীতির শীর্ষ ৫টি সাধারণ নিয়ম');

        // Reading experience features verified
        $response->assertSee('সেপিয়া');
        $response->assertSee('বইয়ের অধ্যায়সমূহ');

        // Verify it is strictly text-based: No MCQ tab or MCQ options
        $response->assertDontSee('প্রিলিমিনারি MCQ অংশ');
        $response->assertDontSee('MCQs');
    }

    public function test_book_chapter_export_printable_text_booklet(): void
    {
        $book = Book::where('slug', 'book-bcs-english')->first();
        $this->assertNotNull($book);

        $response = $this->actingAs($this->student)->get(route('books.export', [
            'slug' => $book->slug,
            'chapterNumber' => 1
        ]));

        $response->assertStatus(200);
        $response->assertSee('Digital Book Series');
        $response->assertSee('Chapter 1: Parts of Speech, Clauses & Sentence Structure');
        $response->assertSee('Clauses: Classification & Identification Rules');
        $response->assertSee('Subject-Verb Agreement: Master Rules & Exceptions');
        $response->assertSee('TargetOfficer Digital Book System');
    }
}
