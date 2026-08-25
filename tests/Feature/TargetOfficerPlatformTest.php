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

    public function test_candidate_dashboard_renders(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();
        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('স্বাগতম');
        $response->assertSee('স্টাডি স্ট্রাইক');
    }

    public function test_exams_index_and_show_pages(): void
    {
        $exam = Exam::first();

        $indexRes = $this->get(route('exams.index'));
        $indexRes->assertStatus(200);
        $indexRes->assertSee($exam->title_bn);

        $showRes = $this->get(route('exams.show', $exam->slug));
        $showRes->assertStatus(200);
        $showRes->assertSee('পরীক্ষার গুরুত্বপূর্ণ নিয়মাবলী');
    }

    public function test_exam_room_and_submission_with_scoring(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();
        $exam = Exam::where('exam_mode', 'timed_mock')->first();

        // 1. Enter exam room
        $roomRes = $this->actingAs($user)->get(route('exams.room', $exam->slug));
        $roomRes->assertStatus(200);
        $roomRes->assertSee('জমা দিন');

        $attempt = ExamAttempt::where('user_id', $user->id)->where('exam_id', $exam->id)->first();
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

        $resLeaderboard = $this->get(route('leaderboard.index'));
        $resLeaderboard->assertStatus(200);
        $resLeaderboard->assertSee('শীর্ষ ক্যান্ডিডেট র‍্যাংকিং');
    }
}
