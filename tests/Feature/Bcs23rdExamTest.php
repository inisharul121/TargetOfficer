<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Bcs23rdExamTest extends TestCase
{
    use RefreshDatabase;

    protected User $candidate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->candidate = User::where('email', 'candidate@targetofficer.com')->first();
    }

    public function test_23rd_bcs_exam_is_seeded_with_100_questions(): void
    {
        $exam = Exam::where('slug', '23rd-bcs-preliminary')->withCount('questions')->first();
        $this->assertNotNull($exam);
        $this->assertEquals(100, $exam->questions_count);
        $this->assertStringContainsString('২৩তম বিসিএস', $exam->title_bn);

        $questionsWithExplanations = Question::where('reference_source', '২৩তম বিসিএস প্রিলিমিনারি পরীক্ষা')
            ->whereNotNull('explanation_bn')
            ->count();
        $this->assertEquals(100, $questionsWithExplanations);
    }

    public function test_candidate_can_access_and_submit_23rd_bcs_exam(): void
    {
        $exam = Exam::where('slug', '23rd-bcs-preliminary')->first();
        $this->assertNotNull($exam);

        // View exam overview
        $response = $this->actingAs($this->candidate)->get(route('exams.show', $exam->slug));
        $response->assertStatus(200);
        $response->assertSee('২৩তম বিসিএস');

        // Enter exam room
        $roomResponse = $this->actingAs($this->candidate)->get(route('exams.room', $exam->slug));
        $roomResponse->assertStatus(200);

        $attempt = ExamAttempt::where('user_id', $this->candidate->id)
            ->where('exam_id', $exam->id)
            ->first();
        $this->assertNotNull($attempt);

        $q1 = $exam->questions()->first();
        $correctOpt = $q1->options()->where('is_correct', true)->first();

        // Submit exam attempt
        $submitResponse = $this->actingAs($this->candidate)->post(route('attempts.submit', $attempt->id), [
            'answers' => [
                (string)$q1->id => $correctOpt?->id,
            ],
            'time_spent' => 120,
            'tab_switches' => 0,
        ]);

        $submitResponse->assertRedirect(route('exams.result', $attempt->id));

        // Result view
        $resultResponse = $this->actingAs($this->candidate)->get(route('exams.result', $attempt->id));
        $resultResponse->assertStatus(200);
        $resultResponse->assertSee('ফলাফল');
        $resultResponse->assertSee($q1->stem_bn);
    }
}
