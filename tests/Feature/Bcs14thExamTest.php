<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Bcs14thExamTest extends TestCase
{
    use RefreshDatabase;

    protected User $candidate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->candidate = User::where('email', 'candidate@targetofficer.com')->first();
    }

    public function test_14th_bcs_exam_is_seeded_with_questions(): void
    {
        $exam = Exam::where('slug', '14th-bcs-preliminary')->withCount('questions')->first();
        $this->assertNotNull($exam);
        $this->assertEquals(95, $exam->questions_count);
        $this->assertStringContainsString('১৪তম বিসিএস', $exam->title_bn);

        $questionsWithExplanations = Question::where('reference_source', '১৪তম বিসিএস প্রিলিমিনারি পরীক্ষা')
            ->whereNotNull('explanation_bn')
            ->count();
        $this->assertEquals(95, $questionsWithExplanations);
    }

    public function test_candidate_can_start_and_view_14th_bcs_exam(): void
    {
        $exam = Exam::where('slug', '14th-bcs-preliminary')->first();
        $this->assertNotNull($exam);

        $response = $this->actingAs($this->candidate)->get(route('exams.show', $exam->slug));
        $response->assertStatus(200);
        $response->assertSee('১৪তম বিসিএস');
    }

    public function test_candidate_can_submit_14th_bcs_attempt_and_view_explanations(): void
    {
        $exam = Exam::where('slug', '14th-bcs-preliminary')->first();
        $this->assertNotNull($exam);

        // Enter exam room
        $roomResponse = $this->actingAs($this->candidate)->get(route('exams.room', $exam->slug));
        $roomResponse->assertStatus(200);

        $attempt = ExamAttempt::where('user_id', $this->candidate->id)
            ->where('exam_id', $exam->id)
            ->first();
        $this->assertNotNull($attempt);

        // Get first question and its correct option
        $q1 = $exam->questions()->first();
        $correctOpt = $q1->options()->where('is_correct', true)->first();

        // Submit exam
        $submitResponse = $this->actingAs($this->candidate)->post(route('attempts.submit', $attempt->id), [
            'answers' => [
                (string)$q1->id => $correctOpt?->id,
            ],
            'time_spent' => 120,
            'tab_switches' => 0,
        ]);

        $submitResponse->assertRedirect(route('exams.result', $attempt->id));

        // View results and ensure bold explanations are rendered
        $resultResponse = $this->actingAs($this->candidate)->get(route('exams.result', $attempt->id));
        $resultResponse->assertStatus(200);
        $resultResponse->assertSee('ফলাফল');
        $resultResponse->assertSee($q1->stem_bn);
        if ($q1->explanation_bn) {
            $resultResponse->assertSee('কাজী নজরুল ইসলাম');
        }
    }
}
