<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookChapter;
use App\Models\BookWrittenContent;
use App\Models\Subject;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::firstOrCreate(
            ['email' => 'admin@targetofficer.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        $this->student = User::firstOrCreate(
            ['email' => 'candidate@targetofficer.com'],
            [
                'name' => 'BCS Candidate',
                'password' => bcrypt('password123'),
                'role' => 'student',
            ]
        );
    }

    public function test_non_admin_cannot_access_admin_books(): void
    {
        $response = $this->actingAs($this->student)->get(route('admin.books.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_books_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.books.index'));
        $response->assertStatus(200);
        $response->assertSee('বিষয়ভিত্তিক ডিজিটাল ই-বুক');
        $response->assertSee('নতুন বই যুক্ত করুন');
    }

    public function test_admin_can_create_new_book(): void
    {
        $subject = Subject::first();
        $this->assertNotNull($subject);

        $response = $this->actingAs($this->admin)->post(route('admin.books.store'), [
            'subject_id' => $subject->id,
            'title_bn' => 'বিসিএস সংবিধান ও আইন সমীক্ষা',
            'title_en' => 'BCS Constitution and Law Review',
            'slug' => 'bcs-constitution-law',
            'description_bn' => 'গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধানের বিস্তারিত লিখিত ও প্রিলিমিনারি গাইড।',
            'cover_theme' => 'emerald',
            'is_published' => '1',
            'is_featured' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('books', [
            'slug' => 'bcs-constitution-law',
            'title_bn' => 'বিসিএস সংবিধান ও আইন সমীক্ষা',
        ]);
    }

    public function test_admin_can_update_existing_book(): void
    {
        $book = Book::first();
        $this->assertNotNull($book);

        $response = $this->actingAs($this->admin)->put(route('admin.books.update', $book->id), [
            'subject_id' => $book->subject_id,
            'title_bn' => $book->title_bn . ' (সম্পাদিত সংস্করণ)',
            'title_en' => $book->title_en,
            'slug' => $book->slug,
            'description_bn' => 'আপডেট করা সংক্ষিপ্ত বিবরণী।',
            'cover_theme' => 'amber',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title_bn' => $book->title_bn . ' (সম্পাদিত সংস্করণ)',
            'cover_theme' => 'amber',
        ]);
    }

    public function test_admin_can_view_book_builder(): void
    {
        $book = Book::with('chapters.writtenContents')->first();
        $this->assertNotNull($book);

        $response = $this->actingAs($this->admin)->get(route('admin.books.builder', $book->id));
        $response->assertStatus(200);
        $response->assertSee($book->title_bn);
        $response->assertSee('নতুন অধ্যায় যোগ করুন');
    }

    public function test_admin_can_add_and_update_chapter(): void
    {
        $book = Book::first();
        $this->assertNotNull($book);

        $maxChapter = $book->chapters()->max('chapter_number') ?? 0;
        $newChapterNum = $maxChapter + 1;

        // Add chapter
        $createResponse = $this->actingAs($this->admin)->post(route('admin.books.chapters.store', $book->id), [
            'chapter_number' => $newChapterNum,
            'title_bn' => 'পরীক্ষামূলক বিশেষ অধ্যায়',
            'title_en' => 'Experimental Special Chapter',
            'summary_bn' => 'বিশেষ অধ্যায়ের সংক্ষিপ্ত বিবরণ',
            'order' => $newChapterNum,
        ]);

        $createResponse->assertRedirect(route('admin.books.builder', $book->id));
        $chapter = BookChapter::where('book_id', $book->id)
            ->where('chapter_number', $newChapterNum)
            ->first();
        $this->assertNotNull($chapter);

        // Update chapter
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.books.chapters.update', $chapter->id), [
            'chapter_number' => $newChapterNum,
            'title_bn' => 'পরীক্ষামূলক বিশেষ অধ্যায় (আপডেট)',
            'title_en' => 'Experimental Special Chapter Updated',
            'summary_bn' => 'আপডেটেড বিবরণ',
            'order' => $newChapterNum,
        ]);

        $updateResponse->assertRedirect(route('admin.books.builder', $book->id));
        $this->assertDatabaseHas('book_chapters', [
            'id' => $chapter->id,
            'title_bn' => 'পরীক্ষামূলক বিশেষ অধ্যায় (আপডেট)',
        ]);
    }

    public function test_admin_can_add_edit_and_delete_topic(): void
    {
        $chapter = BookChapter::first();
        $this->assertNotNull($chapter);

        // 1. Add topic
        $storeResponse = $this->actingAs($this->admin)->post(route('admin.books.topics.store', $chapter->id), [
            'title_bn' => 'বাংলা ব্যাকরণের ইতিবৃত্ত ও বৈশিষ্ট্য',
            'content_type' => 'theory_and_rules',
            'question_bn' => 'বাংলা ব্যাকরণের প্রধান প্রধান আলোচ্য বিষয়গুলো বিশ্লেষণ করুন।',
            'content_bn' => '<p>বাংলা ব্যাকরণের প্রধান চারটি আলোচ্য বিষয় রয়েছে: ধ্বনিতত্ত্ব, রূপতত্ত্ব, বাক্যতত্ত্ব ও অর্থতত্ত্ব।</p>',
            'marks' => 5.0,
            'bcs_reference' => '৩৮তম বিসিএস লিখিত',
            'order' => 1,
        ]);

        $storeResponse->assertRedirect(route('admin.books.builder', $chapter->book_id));
        $topic = BookWrittenContent::where('book_chapter_id', $chapter->id)
            ->where('title_bn', 'বাংলা ব্যাকরণের ইতিবৃত্ত ও বৈশিষ্ট্য')
            ->first();
        $this->assertNotNull($topic);

        // 2. View Edit Page
        $editResponse = $this->actingAs($this->admin)->get(route('admin.books.topics.edit', $topic->id));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('বাংলা ব্যাকরণের প্রধান চারটি আলোচ্য বিষয় রয়েছে');

        // 3. Update Topic
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.books.topics.update', $topic->id), [
            'title_bn' => 'বাংলা ব্যাকরণের ইতিবৃত্ত ও বৈশিষ্ট্য (সংশোধিত)',
            'content_type' => 'written_question_solution',
            'question_bn' => 'সংশোধিত প্রশ্ন',
            'content_bn' => '<p>সংশোধিত বিস্তারিত ব্যাখ্যা ও সমাধান।</p>',
            'marks' => 10.0,
            'bcs_reference' => '৩৮তম ও ৪৩তম বিসিএস লিখিত',
            'order' => 1,
        ]);

        $updateResponse->assertRedirect(route('admin.books.builder', $chapter->book_id));
        $this->assertDatabaseHas('book_written_contents', [
            'id' => $topic->id,
            'title_bn' => 'বাংলা ব্যাকরণের ইতিবৃত্ত ও বৈশিষ্ট্য (সংশোধিত)',
            'content_type' => 'written_question_solution',
            'marks' => 10.0,
        ]);

        // 4. Delete Topic
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.books.topics.destroy', $topic->id));
        $deleteResponse->assertRedirect(route('admin.books.builder', $chapter->book_id));
        $this->assertDatabaseMissing('book_written_contents', [
            'id' => $topic->id,
        ]);
    }

    public function test_admin_can_delete_chapter_and_book(): void
    {
        $book = Book::create([
            'subject_id' => Subject::first()->id,
            'title_bn' => 'টেস্ট মোছার বই',
            'title_en' => 'Test Delete Book',
            'slug' => 'test-delete-book',
            'is_published' => true,
        ]);

        $chapter = BookChapter::create([
            'book_id' => $book->id,
            'chapter_number' => 1,
            'title_bn' => 'টেস্ট মোছার অধ্যায়',
            'order' => 1,
        ]);

        // Delete chapter
        $delChapterResponse = $this->actingAs($this->admin)->delete(route('admin.books.chapters.destroy', $chapter->id));
        $delChapterResponse->assertRedirect(route('admin.books.builder', $book->id));
        $this->assertDatabaseMissing('book_chapters', ['id' => $chapter->id]);

        // Delete book
        $delBookResponse = $this->actingAs($this->admin)->delete(route('admin.books.destroy', $book->id));
        $delBookResponse->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
