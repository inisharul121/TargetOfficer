<?php

namespace Tests\Feature;

use App\Models\CurrentAffair;
use App\Models\Exam;
use App\Models\Flashcard;
use App\Models\Question;
use App\Models\QuizDuel;
use App\Models\StudyRoutine;
use App\Models\Subject;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvancedFeaturesTest extends TestCase
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

    public function test_live_exams_lobby_and_leaderboard(): void
    {
        $response = $this->actingAs($this->student)->get(route('live-exams.index'));
        $response->assertStatus(200);
        $response->assertSee('লাইভ মডেল টেস্ট');

        $exam = Exam::where('exam_mode', 'live_model_test')->first();
        $this->assertNotNull($exam);

        $lbResponse = $this->actingAs($this->student)->get(route('live-exams.leaderboard', $exam->slug));
        $lbResponse->assertStatus(200);
        $lbResponse->assertSee('জাতীয় মেধা তালিকা');
    }

    public function test_study_routine_and_toggle_completion(): void
    {
        $response = $this->actingAs($this->student)->get(route('routine.index'));
        $response->assertStatus(200);
        $response->assertSee('সাপ্তাহিক সিলেবাস ট্র্যাকার');

        $routine = StudyRoutine::first();
        $this->assertNotNull($routine);

        $initialCoins = $this->student->coins;

        $toggleResponse = $this->actingAs($this->student)
            ->postJson(route('routine.toggle', $routine->id));

        $toggleResponse->assertStatus(200);
        $toggleResponse->assertJson(['success' => true, 'completed' => true]);

        $this->student->refresh();
        $this->assertEquals($initialCoins + 5, $this->student->coins);
    }

    public function test_quiz_duel_workflow(): void
    {
        // 1. Create a duel
        $response = $this->actingAs($this->student)->post(route('battle.store'));
        $response->assertRedirect();

        $duel = QuizDuel::where('creator_id', $this->student->id)->latest()->first();
        $this->assertNotNull($duel);
        $this->assertCount(10, $duel->question_ids);

        // 2. Arena
        $arenaResponse = $this->actingAs($this->student)->get(route('battle.arena', $duel->duel_code));
        $arenaResponse->assertStatus(200);
        $arenaResponse->assertSee($duel->duel_code);

        // 3. Submit
        $submitResponse = $this->actingAs($this->student)->post(route('battle.submit', $duel->duel_code), [
            'answers' => [],
            'time_taken_seconds' => 45,
        ]);
        $submitResponse->assertRedirect(route('battle.result', $duel->duel_code));

        // 4. Result
        $resultResponse = $this->actingAs($this->student)->get(route('battle.result', $duel->duel_code));
        $resultResponse->assertStatus(200);
    }

    public function test_flashcards_mastery_tracking(): void
    {
        $response = $this->actingAs($this->student)->get(route('flashcards.index'));
        $response->assertStatus(200);
        $response->assertSee('স্মার্ট ফ্ল্যাশ কার্ড');

        $card = Flashcard::first();
        $this->assertNotNull($card);

        $initialCoins = $this->student->coins;

        $rateResponse = $this->actingAs($this->student)
            ->postJson(route('flashcards.rate', $card->id), [
                'is_mastered' => true,
            ]);

        $rateResponse->assertStatus(200);
        $rateResponse->assertJson(['success' => true, 'is_mastered' => true]);

        $this->student->refresh();
        $this->assertEquals($initialCoins + 2, $this->student->coins);
    }

    public function test_current_affairs_feed(): void
    {
        $response = $this->actingAs($this->student)->get(route('current-affairs.index'));
        $response->assertStatus(200);
        $response->assertSee('মাসিক ও দৈনিক কারেন্ট অ্যাফেয়ার্স');
    }

    public function test_pdf_export_views(): void
    {
        $exam = Exam::first();
        $response = $this->actingAs($this->student)->get(route('export.exam', $exam->id) . '?mode=questions');
        $response->assertStatus(200);
        $response->assertSee('TargetOfficer');

        $qbResponse = $this->actingAs($this->student)->get(route('export.question-bank') . '?mode=solutions');
        $qbResponse->assertStatus(200);
        $qbResponse->assertSee('সঠিক উত্তর:');
    }

    public function test_bangla_phonetic_search(): void
    {
        // Search 'natok' in Question Bank should find questions about 'নাটক'
        $response = $this->actingAs($this->student)->get(route('question-bank.index', ['q' => 'natok']));
        $response->assertStatus(200);
        $response->assertSee('নাটক');
    }
}
