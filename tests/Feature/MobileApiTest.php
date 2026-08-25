<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_api_can_fetch_taxonomies(): void
    {
        $response = $this->getJson('/api/v1/subjects');
        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'data']);

        $setterRes = $this->getJson('/api/v1/setter-bodies');
        $setterRes->assertStatus(200);
        $setterRes->assertJsonStructure(['status', 'data']);
    }

    public function test_api_auth_login_and_token_generation(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'candidate@targetofficer.com',
            'password' => 'password123',
            'device_name' => 'Flutter_Android_App',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'token', 'user']);
    }

    public function test_api_exam_lifecycle_for_mobile_apps(): void
    {
        $user = User::where('email', 'candidate@targetofficer.com')->first();
        $token = $user->createToken('test_mobile_token')->plainTextToken;

        $exam = Exam::first();

        // 1. Start Exam via Mobile API
        $startRes = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/exams/{$exam->id}/start");

        $startRes->assertStatus(200);
        $startRes->assertJsonStructure(['status', 'attempt', 'questions']);

        $attemptId = $startRes->json('attempt.id');
        $qId = $startRes->json('questions.0.id');
        $optId = $startRes->json('questions.0.options.0.id');

        // 2. Autosave via Mobile API
        $saveRes = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/attempts/{$attemptId}/autosave", [
                'answers' => [(string)$qId => $optId],
                'tab_switches' => 0,
            ]);
        $saveRes->assertStatus(200);
        $saveRes->assertJson(['status' => 'success']);

        // 3. Submit Exam via Mobile API
        $submitRes = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/attempts/{$attemptId}/submit", [
                'answers' => [(string)$qId => $optId],
                'time_spent' => 90,
                'tab_switches' => 0,
            ]);

        $submitRes->assertStatus(200);
        $submitRes->assertJsonStructure(['status', 'result' => ['total_score', 'accuracy_percentage']]);
    }
}
