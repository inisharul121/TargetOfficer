<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TargetOfficerPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('TargetOfficer');
        $response->assertSee('Public Service');
    }

    public function test_candidate_can_login_with_demo(): void
    {
        $response = $this->get(route('demo.login', 'student'));
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    public function test_candidate_can_register_without_target_exam(): void
    {
        $response = $this->post(route('register.post'), [
            'name' => 'New Candidate',
            'email' => 'newcandidate@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'newcandidate@example.com',
        ]);
    }

    public function test_candidate_dashboard_renders(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();
        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('স্বাগতম');
        $response->assertSee('নির্ভুলতার হার');
        $response->assertDontSee('অ্যাডমিন হাব');
        $response->assertDontSee('প্রশ্ন ব্যাংক রিপোজিটরি');
        $response->assertDontSee('ক্যালিব্রেশন অ্যানালিটিক্স');
    }

    public function test_student_portal_pages_render(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();

        // 1. Progress page
        $progressRes = $this->actingAs($user)->get(route('student.progress'));
        $progressRes->assertStatus(200);
        $progressRes->assertSee('পারফরম্যান্স ও অগ্রগতি');

        // 2. Mistake bank
        $mistakeRes = $this->actingAs($user)->get(route('student.mistakes'));
        $mistakeRes->assertStatus(200);
        $mistakeRes->assertSee('ভুল উত্তরের ব্যাংক');

        // 3. Custom exam setup page
        $customRes = $this->actingAs($user)->get(route('exams.custom'));
        $customRes->assertStatus(200);
        $customRes->assertSee('কাস্টম পরীক্ষা');

        // 4. Practice reading mode
        $practiceRes = $this->actingAs($user)->get(route('practice.index'));
        $practiceRes->assertStatus(200);
        $practiceRes->assertSee('বিষয়ভিত্তিক অনুশীলন');

        // 5. Question bank archive
        $qbRes = $this->actingAs($user)->get(route('question-bank.index'));
        $qbRes->assertStatus(200);
        $qbRes->assertSee('প্রশ্ন ব্যাংক');
    }

    public function test_generate_custom_exam_with_filters(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();
        $exam = Exam::first();

        $postRes = $this->actingAs($user)->post(route('exams.custom.store'), [
            'title' => 'My Custom Practice Test',
            'exam_id' => $exam->id,
            'question_count' => 10,
            'duration_minutes' => 15,
            'negative_marking' => 0.25,
            'pool_type' => 'all',
        ]);

        $postRes->assertRedirect();
        $this->assertDatabaseHas('exams', [
            'exam_mode' => 'custom',
            'created_by' => $user->id,
        ]);
    }

    public function test_exams_index_and_show_pages(): void
    {
        $exam = Exam::latest()->first();

        $indexRes = $this->get(route('exams.index'));
        $indexRes->assertStatus(200);
        $indexRes->assertSee($exam->title_bn);

        $showRes = $this->get(route('exams.show', $exam->slug));
        $showRes->assertStatus(200);
        $showRes->assertSee('পরীক্ষার গুরুত্বপূর্ণ নিয়মাবলী');
    }

    public function test_exam_room_and_submission_with_scoring(): void
    {
        // Use an existing exam with questions
        $user = User::where('email', 'candidate@targetofficer.com')->first();
        $exam = Exam::where('exam_mode', 'daily_quiz')->first() ?? Exam::has('questions')->first() ?? Exam::first();

        // 1. Enter exam room
        $roomRes = $this->actingAs($user)->get(route('exams.room', $exam->slug));
        $roomRes->assertStatus(200);
        $roomRes->assertSee('জমা দিন');

        $attempt = ExamAttempt::where('user_id', $user->id)->where('exam_id', $exam->id)->where('status', 'in_progress')->first();
        $this->assertNotNull($attempt);
        $this->assertEquals('in_progress', $attempt->status);

        // 2. Submit answers (1 correct, 1 wrong)
        $q1 = $exam->questions()->first();
        $q1CorrectOpt = $q1->options()->where('is_correct', true)->first();

        $submittedAnswers = [
            (string)$q1->id => $q1CorrectOpt->id,
        ];

        $submitRes = $this->actingAs($user)->post(route('attempts.submit', $attempt->id), [
            'answers' => $submittedAnswers,
            'time_spent' => 120,
            'tab_switches' => 1,
        ]);

        $submitRes->assertRedirect(route('exams.result', $attempt->id));

        $attempt->refresh();
        $this->assertEquals('completed', $attempt->status);
        $this->assertEquals(1, $attempt->total_correct);
        $this->assertEquals(1.00, $attempt->total_score);
        $this->assertEquals(1, $attempt->tab_switch_count);

        // 3. View result scorecard
        $resultRes = $this->actingAs($user)->get(route('exams.result', $attempt->id));
        $resultRes->assertStatus(200);
        $resultRes->assertSee('পরীক্ষার অফিসিয়াল ফলাফল');
    }

    public function test_custom_exam_generator(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();

        $response = $this->actingAs($user)->post(route('exams.custom.store'), [
            'question_count' => 5,
            'difficulty' => 'medium',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('exams', [
            'exam_mode' => 'custom',
            'created_by' => $user->id,
        ]);
    }

    public function test_practice_mode_and_question_bank(): void
    {
        $resPractice = $this->get(route('practice.index', ['subject' => 'bangla']));
        $resPractice->assertStatus(200);

        $resBank = $this->get(route('question-bank.index'));
        $resBank->assertStatus(200);
        $resBank->assertSee('প্রশ্ন ব্যাংক ও প্রশ্নকর্তা প্যাটার্ন আর্কাইভ');
    }

    public function test_candidate_can_post_question_discussion_comment(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();
        $question = Question::first();

        $initialCoins = $user->coins;

        $response = $this->actingAs($user)->post(route('questions.comments.store', $question->id), [
            'comment' => 'চর্যাপদের আদি কবি লুইপা হলেও সর্বাধিক পদ রচয়িতা কাহ্নপা। এটি গুরুত্বপূর্ণ তথ্য।',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('question_comments', [
            'question_id' => $question->id,
            'user_id' => $user->id,
        ]);

        $user->refresh();
        $this->assertEquals($initialCoins + 5, $user->coins);
    }
}
