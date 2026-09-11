<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Bcs15thTo17thExamTest extends TestCase
{
    use RefreshDatabase;

    protected User $candidate;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->candidate = User::where('email', 'candidate@targetofficer.com')->first();
    }

    public function test_15th_bcs_exam_is_seeded_with_100_questions(): void
    {
        $exam = Exam::where('slug', '15th-bcs-preliminary')->withCount('questions')->first();
        $this->assertNotNull($exam);
        $this->assertEquals(100, $exam->questions_count);
        $this->assertStringContainsString('১৫তম বিসিএস', $exam->title_bn);

        $questionsWithExplanations = Question::where('reference_source', '১৫তম বিসিএস প্রিলিমিনারি পরীক্ষা')
            ->whereNotNull('explanation_bn')
            ->count();
        $this->assertEquals(100, $questionsWithExplanations);
    }

    public function test_16th_bcs_exam_is_seeded_with_100_questions(): void
    {
        $exam = Exam::where('slug', '16th-bcs-preliminary')->withCount('questions')->first();
        $this->assertNotNull($exam);
        $this->assertEquals(100, $exam->questions_count);
        $this->assertStringContainsString('১৬তম বিসিএস', $exam->title_bn);

        $questionsWithExplanations = Question::where('reference_source', '১৬তম বিসিএস প্রিলিমিনারি পরীক্ষা')
            ->whereNotNull('explanation_bn')
            ->count();
        $this->assertEquals(100, $questionsWithExplanations);
    }

    public function test_17th_bcs_exam_is_seeded_with_100_questions(): void
    {
        $exam = Exam::where('slug', '17th-bcs-preliminary')->withCount('questions')->first();
        $this->assertNotNull($exam);
        $this->assertEquals(100, $exam->questions_count);
        $this->assertStringContainsString('১৭তম বিসিএস', $exam->title_bn);

        $questionsWithExplanations = Question::where('reference_source', '১৭তম বিসিএস প্রিলিমিনারি পরীক্ষা')
            ->whereNotNull('explanation_bn')
            ->count();
        $this->assertEquals(100, $questionsWithExplanations);
    }

    public function test_candidate_can_access_and_submit_15th_bcs_exam(): void
    {
        $exam = Exam::where('slug', '15th-bcs-preliminary')->first();
        $this->assertNotNull($exam);

        $response = $this->actingAs($this->candidate)->get(route('exams.show', $exam->slug));
        $response->assertStatus(200);
        $response->assertSee('১৫তম বিসিএস');

        $roomResponse = $this->actingAs($this->candidate)->get(route('exams.room', $exam->slug));
        $roomResponse->assertStatus(200);

        $attempt = ExamAttempt::where('user_id', $this->candidate->id)
            ->where('exam_id', $exam->id)
            ->first();
        $this->assertNotNull($attempt);

        $q1 = $exam->questions()->first();
        $correctOpt = $q1->options()->where('is_correct', true)->first();

        $submitResponse = $this->actingAs($this->candidate)->post(route('attempts.submit', $attempt->id), [
            'answers' => [
                (string)$q1->id => $correctOpt?->id,
            ],
            'time_spent' => 120,
            'tab_switches' => 0,
        ]);

        $submitResponse->assertRedirect(route('exams.result', $attempt->id));

        $resultResponse = $this->actingAs($this->candidate)->get(route('exams.result', $attempt->id));
        $resultResponse->assertStatus(200);
        $resultResponse->assertSee('ফলাফল');
        $resultResponse->assertSee($q1->stem_bn);
    }

    public function test_candidate_can_access_and_submit_16th_bcs_exam(): void
    {
        $exam = Exam::where('slug', '16th-bcs-preliminary')->first();
        $this->assertNotNull($exam);

        $response = $this->actingAs($this->candidate)->get(route('exams.show', $exam->slug));
        $response->assertStatus(200);
        $response->assertSee('১৬তম বিসিএস');

        $roomResponse = $this->actingAs($this->candidate)->get(route('exams.room', $exam->slug));
        $roomResponse->assertStatus(200);

        $attempt = ExamAttempt::where('user_id', $this->candidate->id)
            ->where('exam_id', $exam->id)
            ->first();
        $this->assertNotNull($attempt);

        $q1 = $exam->questions()->first();
        $correctOpt = $q1->options()->where('is_correct', true)->first();

        $submitResponse = $this->actingAs($this->candidate)->post(route('attempts.submit', $attempt->id), [
            'answers' => [
                (string)$q1->id => $correctOpt?->id,
            ],
            'time_spent' => 120,
            'tab_switches' => 0,
        ]);

        $submitResponse->assertRedirect(route('exams.result', $attempt->id));

        $resultResponse = $this->actingAs($this->candidate)->get(route('exams.result', $attempt->id));
        $resultResponse->assertStatus(200);
        $resultResponse->assertSee('ফলাফল');
        $resultResponse->assertSee($q1->stem_bn);
    }

    public function test_candidate_can_access_and_submit_17th_bcs_exam(): void
    {
        $exam = Exam::where('slug', '17th-bcs-preliminary')->first();
        $this->assertNotNull($exam);

        $response = $this->actingAs($this->candidate)->get(route('exams.show', $exam->slug));
        $response->assertStatus(200);
        $response->assertSee('১৭তম বিসিএস');

        $roomResponse = $this->actingAs($this->candidate)->get(route('exams.room', $exam->slug));
        $roomResponse->assertStatus(200);

        $attempt = ExamAttempt::where('user_id', $this->candidate->id)
            ->where('exam_id', $exam->id)
            ->first();
        $this->assertNotNull($attempt);

        $q1 = $exam->questions()->first();
        $correctOpt = $q1->options()->where('is_correct', true)->first();

        $submitResponse = $this->actingAs($this->candidate)->post(route('attempts.submit', $attempt->id), [
            'answers' => [
                (string)$q1->id => $correctOpt?->id,
            ],
            'time_spent' => 120,
            'tab_switches' => 0,
        ]);

        $submitResponse->assertRedirect(route('exams.result', $attempt->id));

        $resultResponse = $this->actingAs($this->candidate)->get(route('exams.result', $attempt->id));
        $resultResponse->assertStatus(200);
        $resultResponse->assertSee('ফলাফল');
        $resultResponse->assertSee($q1->stem_bn);
    }
}
