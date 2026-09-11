<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LiveExamSeeder extends Seeder
{
    public function run(): void
    {
        $allQuestions = Question::where('status', 'published')->pluck('id')->toArray();
        if (empty($allQuestions)) {
            return;
        }

        $now = now();

        // 1. Currently Active Live Model Test
        $liveExam1 = Exam::updateOrCreate(
            ['slug' => '46th-bcs-special-live-model-test-01'],
            [
                'title_bn' => '৪৬তম বিসিএস স্পেশাল লাইভ মডেল টেস্ট - ০১',
                'title_en' => '46th BCS Special Live Model Test 01',
                'description_bn' => 'সারাদেশের বিসিএস পরীক্ষার্থীদের সাথে একই সময়ে অনুষ্ঠিত লাইভ মডেল টেস্ট। নেগেটিভ মার্কিং ০.৫০ এবং তাৎক্ষণিক মেধা তালিকা।',
                'exam_mode' => 'live_model_test',
                'total_questions' => 30,
                'total_marks' => 30.00,
                'duration_minutes' => 25,
                'negative_mark_per_question' => 0.50,
                'pass_percentage' => 50.00,
                'is_published' => true,
                'allow_pause' => false,
                'scheduled_start_at' => $now->copy()->subMinutes(15),
                'scheduled_end_at' => $now->copy()->addHours(6),
            ]
        );

        // Attach 30 questions
        $selectedQ1 = array_slice($allQuestions, 0, 30);
        foreach ($selectedQ1 as $index => $qId) {
            ExamQuestion::firstOrCreate([
                'exam_id' => $liveExam1->id,
                'question_id' => $qId,
            ], [
                'marks' => 1.00,
                'negative_marks' => 0.50,
                'order' => $index + 1,
            ]);
        }

        // 2. Upcoming Live Exam (Tomorrow 9 PM)
        $liveExam2 = Exam::updateOrCreate(
            ['slug' => '47th-bcs-advance-live-model-test-02'],
            [
                'title_bn' => '৪৭তম বিসিএস অগ্রিম প্রস্তুতি লাইভ টেস্ট - ০২',
                'title_en' => '47th BCS Advance Prep Live Test 02',
                'description_bn' => 'বাংলা ভাষা ও সাহিত্য এবং বাংলাদেশ বিষয়াবলীর ওপর বিশেষ জাতীয় লাইভ মডেল টেস্ট।',
                'exam_mode' => 'live_model_test',
                'total_questions' => 30,
                'total_marks' => 30.00,
                'duration_minutes' => 25,
                'negative_mark_per_question' => 0.50,
                'pass_percentage' => 50.00,
                'is_published' => true,
                'allow_pause' => false,
                'scheduled_start_at' => $now->copy()->addDay()->setTime(21, 0),
                'scheduled_end_at' => $now->copy()->addDay()->setTime(22, 0),
            ]
        );

        $selectedQ2 = array_slice($allQuestions, 30, 30);
        foreach ($selectedQ2 as $index => $qId) {
            ExamQuestion::firstOrCreate([
                'exam_id' => $liveExam2->id,
                'question_id' => $qId,
            ], [
                'marks' => 1.00,
                'negative_marks' => 0.50,
                'order' => $index + 1,
            ]);
        }

        // 3. Past Completed Live Exam with National Merit List
        $pastLiveExam = Exam::updateOrCreate(
            ['slug' => 'bcs-grand-live-model-test-national-archive'],
            [
                'title_bn' => 'বিসিএস গ্র্যান্ড লাইভ মডেল টেস্ট (জাতীয় আর্কাইভ)',
                'title_en' => 'BCS Grand Live Model Test National Archive',
                'description_bn' => 'সারাদেশের ৫,০০০+ পরীক্ষার্থী অংশগ্রহণকারী জাতীয় মডেল টেস্টের চূড়ান্ত মেধা তালিকা ও র‍্যাঙ্কিং।',
                'exam_mode' => 'live_model_test',
                'total_questions' => 30,
                'total_marks' => 30.00,
                'duration_minutes' => 25,
                'negative_mark_per_question' => 0.50,
                'pass_percentage' => 50.00,
                'is_published' => true,
                'allow_pause' => false,
                'scheduled_start_at' => $now->copy()->subDays(2),
                'scheduled_end_at' => $now->copy()->subDays(2)->addHours(3),
            ]
        );

        $selectedQ3 = array_slice($allQuestions, 60, 30);
        foreach ($selectedQ3 as $index => $qId) {
            ExamQuestion::firstOrCreate([
                'exam_id' => $pastLiveExam->id,
                'question_id' => $qId,
            ], [
                'marks' => 1.00,
                'negative_marks' => 0.50,
                'order' => $index + 1,
            ]);
        }

        // Seed 10 realistic competitor attempts for the past live exam to populate National Merit List
        $dummyCandidates = [
            ['name' => 'তানভীর আহমেদ', 'email' => 'tanvir.bcs@gmail.com', 'score' => 28.50, 'correct' => 29, 'incorrect' => 1, 'time' => 910],
            ['name' => 'নুসরাত জাহান মীম', 'email' => 'nusrat.meem@gmail.com', 'score' => 27.00, 'correct' => 28, 'incorrect' => 2, 'time' => 980],
            ['name' => 'রাকিবুল হাসান সাজিদ', 'email' => 'rakibul.sajid@yahoo.com', 'score' => 26.50, 'correct' => 27, 'incorrect' => 1, 'time' => 1020],
            ['name' => 'ফাহমিদা সুলতানা', 'email' => 'fahmida.s@gmail.com', 'score' => 25.00, 'correct' => 26, 'incorrect' => 2, 'time' => 1100],
            ['name' => 'মাহমুদুল হক', 'email' => 'mahmud.haque@gmail.com', 'score' => 23.50, 'correct' => 25, 'incorrect' => 3, 'time' => 1150],
            ['name' => 'আফরোজা পারভীন', 'email' => 'afroza.parveen@gmail.com', 'score' => 22.00, 'correct' => 24, 'incorrect' => 4, 'time' => 1200],
            ['name' => 'শফিকুল ইসলাম', 'email' => 'shafiq.du@gmail.com', 'score' => 20.50, 'correct' => 22, 'incorrect' => 3, 'time' => 1240],
            ['name' => 'সাবরিনা আক্তার', 'email' => 'sabrina.bcs@gmail.com', 'score' => 19.00, 'correct' => 21, 'incorrect' => 4, 'time' => 1300],
        ];

        foreach ($dummyCandidates as $cand) {
            $user = User::firstOrCreate(
                ['email' => $cand['email']],
                [
                    'name' => $cand['name'],
                    'password' => bcrypt('password123'),
                    'role' => 'candidate',
                    'coins' => 100,
                    'daily_streak' => 5,
                ]
            );

            ExamAttempt::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'exam_id' => $pastLiveExam->id,
                ],
                [
                    'status' => 'completed',
                    'total_score' => $cand['score'],
                    'total_correct' => $cand['correct'],
                    'total_incorrect' => $cand['incorrect'],
                    'total_unanswered' => 30 - ($cand['correct'] + $cand['incorrect']),
                    'total_negative_marks' => $cand['incorrect'] * 0.50,
                    'accuracy_percentage' => round(($cand['correct'] / ($cand['correct'] + $cand['incorrect'])) * 100, 2),
                    'time_taken_seconds' => $cand['time'],
                    'started_at' => $pastLiveExam->scheduled_start_at,
                    'completed_at' => $pastLiveExam->scheduled_start_at->copy()->addSeconds($cand['time']),
                ]
            );
        }
    }
}
