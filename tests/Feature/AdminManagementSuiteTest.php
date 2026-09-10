<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\Organization;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\Subject;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::where('email', 'admin@targetofficer.com')->first();
        $this->student = User::where('email', 'candidate@targetofficer.com')->first();
    }

    public function test_students_are_forbidden_from_admin_portal(): void
    {
        $response = $this->actingAs($this->student)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_dashboard_with_metrics(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('অ্যাডমিন ড্যাশবোর্ড');
        $response->assertSee('প্রশ্নকর্তা সংস্থা বিশ্লেষণ');
    }

    public function test_admin_can_create_exam_and_use_question_builder(): void
    {
        // 1. Create Exam
        $response = $this->actingAs($this->admin)->post(route('admin.exams.store'), [
            'title_bn' => '৪৭তম বিসিএস মডেল টেস্ট - সুপার স্পেশাল',
            'title_en' => '47th BCS Super Special Mock',
            'exam_mode' => 'timed_mock',
            'duration_minutes' => 45,
            'pass_percentage' => 50,
            'negative_mark_per_question' => 0.50,
            'is_published' => 1,
        ]);

        $exam = Exam::where('title_bn', '৪৭তম বিসিএস মডেল টেস্ট - সুপার স্পেশাল')->first();
        $this->assertNotNull($exam);
        $response->assertRedirect(route('admin.exams.builder', $exam->id));

        // 2. Open Builder
        $builderRes = $this->actingAs($this->admin)->get(route('admin.exams.builder', $exam->id));
        $builderRes->assertStatus(200);
        $builderRes->assertSee('Interactive Exam Builder');

        // 3. Attach a question manually
        $question = Question::first();
        $attachRes = $this->actingAs($this->admin)->post(route('admin.exams.attach-question', $exam->id), [
            'question_id' => $question->id,
            'marks' => 1.00,
        ]);
        $attachRes->assertRedirect();
        $this->assertTrue($exam->questions()->where('question_id', $question->id)->exists());

        // 4. Detach question
        $detachRes = $this->actingAs($this->admin)->post(route('admin.exams.detach-question', [$exam->id, $question->id]));
        $detachRes->assertRedirect();
        $this->assertFalse($exam->questions()->where('question_id', $question->id)->exists());

        // 5. Auto-assign questions
        $autoRes = $this->actingAs($this->admin)->post(route('admin.exams.auto-assign', $exam->id), [
            'count' => 3,
        ]);
        $autoRes->assertRedirect();
        $this->assertEquals(3, $exam->questions()->count());
    }

    public function test_admin_can_edit_question_and_resolve_duplicates(): void
    {
        $question = Question::first();

        $editRes = $this->actingAs($this->admin)->get(route('admin.questions.edit', $question->id));
        $editRes->assertStatus(200);
        $editRes->assertSee('প্রশ্ন সম্পাদন');

        $updateRes = $this->actingAs($this->admin)->put(route('admin.questions.update', $question->id), [
            'subject_id' => $question->subject_id,
            'stem_bn' => 'হালনাগাদ করা প্রশ্ন মূল বক্তব্য',
            'difficulty' => 'hard',
            'default_marks' => 1.00,
            'negative_marks' => 0.50,
            'status' => 'published',
            'options' => [
                ['text_bn' => 'অপশন ১'],
                ['text_bn' => 'অপশন ২'],
                ['text_bn' => 'অপশন ৩'],
                ['text_bn' => 'অপশন ৪'],
            ],
            'correct_option' => 1,
            'tags' => '47th BCS,Updated Tag',
        ]);

        $updateRes->assertRedirect(route('admin.questions.index'));
        $question->refresh();
        $this->assertEquals('হালনাগাদ করা প্রশ্ন মূল বক্তব্য', $question->stem_bn);
        $this->assertEquals('hard', $question->difficulty);

        // Duplicate checker page
        $dupRes = $this->actingAs($this->admin)->get(route('admin.questions.duplicates'));
        $dupRes->assertStatus(200);
    }

    public function test_admin_can_moderate_question_error_reports(): void
    {
        $question = Question::first();
        $report = QuestionReport::create([
            'question_id' => $question->id,
            'user_id' => $this->student->id,
            'report_type' => 'wrong_answer',
            'comment' => 'অপশন বি এর পরিবর্তে অপশন সি সঠিক উত্তর হবে।',
            'status' => 'pending',
        ]);

        $indexRes = $this->actingAs($this->admin)->get(route('admin.reports.index'));
        $indexRes->assertStatus(200);
        $indexRes->assertSee('ভুল উত্তর');

        $resolveRes = $this->actingAs($this->admin)->put(route('admin.reports.status', $report->id), [
            'status' => 'resolved',
        ]);
        $resolveRes->assertRedirect();

        $report->refresh();
        $this->assertEquals('resolved', $report->status);
    }

    public function test_admin_can_manage_taxonomies(): void
    {
        // 1. Add Subject
        $subRes = $this->actingAs($this->admin)->post(route('admin.taxonomies.subject.store'), [
            'name_bn' => 'নৈতিকতা, মূল্যবোধ ও সুশাসন',
            'name_en' => 'Ethics, Values & Good Governance',
            'color' => '#14B8A6',
        ]);
        $subRes->assertRedirect();
        $this->assertDatabaseHas('subjects', ['name_en' => 'Ethics, Values & Good Governance']);

        // 2. Add Organization / Question Setter
        $orgRes = $this->actingAs($this->admin)->post(route('admin.taxonomies.organization.store'), [
            'name_bn' => 'মিলিটারি ইনস্টিটিউট অব সায়েন্স অ্যান্ড টেকনোলজি',
            'name_en' => 'Military Institute of Science and Technology',
            'code' => 'MIST',
            'is_question_setter' => 1,
        ]);
        $orgRes->assertRedirect();
        $this->assertDatabaseHas('organizations', ['code' => 'MIST']);
    }

    public function test_admin_can_manage_users_and_view_analytics(): void
    {
        // User list & role promote
        $userRes = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $userRes->assertStatus(200);

        $roleRes = $this->actingAs($this->admin)->put(route('admin.users.role', $this->student->id), [
            'role' => 'setter',
            'coins' => 300,
        ]);
        $roleRes->assertRedirect();

        $this->student->refresh();
        $this->assertEquals('setter', $this->student->role);
        $this->assertEquals(300, $this->student->coins);

        // Analytics page
        $analyticsRes = $this->actingAs($this->admin)->get(route('admin.analytics.index'));
        $analyticsRes->assertStatus(200);
        $analyticsRes->assertSee('প্ল্যাটফর্ম ও প্রশ্ন ক্যালিব্রেশন অ্যানালিটিক্স');
    }
}
