<?php

namespace App\Services;

use App\Models\AttemptAnswer;
use App\Models\Badge;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamService
{
    /**
     * Start or resume an exam attempt.
     */
    public function startAttempt(User $user, Exam $exam): ExamAttempt
    {
        // Check if there is an unfinished attempt
        $existing = ExamAttempt::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->where('status', 'in_progress')
            ->first();

        if ($existing) {
            return $existing;
        }

        return DB::transaction(function () use ($user, $exam) {
            $attempt = ExamAttempt::create([
                'user_id' => $user->id,
                'exam_id' => $exam->id,
                'status' => 'in_progress',
                'started_at' => now(),
                'answers_state' => [],
            ]);

            // Load questions
            $examQuestions = $exam->questions()
                ->with(['options', 'subject', 'setterOrganization'])
                ->get();

            if ($exam->shuffle_questions) {
                $examQuestions = $examQuestions->shuffle();
            }

            $order = 1;
            foreach ($examQuestions as $question) {
                AttemptAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'marks_awarded' => 0.00,
                    'is_correct' => null,
                ]);
                $order++;
            }

            return $attempt;
        });
    }

    /**
     * Auto-save answers snapshot during the exam.
     */
    public function saveProgress(ExamAttempt $attempt, array $answersState, int $tabSwitches = 0): void
    {
        if ($attempt->status !== 'in_progress') {
            return;
        }

        $attempt->answers_state = $answersState;
        $attempt->tab_switch_count = $tabSwitches;
        $attempt->save();
    }

    /**
     * Submit and calculate official exam results.
     */
    public function submitAttempt(
        ExamAttempt $attempt,
        array $submittedAnswers,
        int $timeSpentSeconds,
        int $tabSwitches = 0
    ): ExamAttempt {
        if ($attempt->status === 'completed') {
            return $attempt;
        }

        return DB::transaction(function () use ($attempt, $submittedAnswers, $timeSpentSeconds, $tabSwitches) {
            $exam = $attempt->exam;
            $user = $attempt->user;

            $totalCorrect = 0;
            $totalIncorrect = 0;
            $totalUnanswered = 0;
            $totalNegativeMarks = 0.00;
            $totalScore = 0.00;

            $answers = $attempt->answers()->with('question.options')->get();

            foreach ($answers as $attemptAnswer) {
                $question = $attemptAnswer->question;
                $qid = (string)$question->id;
                
                // Get selected option from payload
                $selectedOptionId = $submittedAnswers[$qid] ?? null;
                $attemptAnswer->selected_option_id = $selectedOptionId ? (int)$selectedOptionId : null;

                if (empty($selectedOptionId)) {
                    $totalUnanswered++;
                    $attemptAnswer->is_correct = null;
                    $attemptAnswer->marks_awarded = 0.00;
                } else {
                    $selectedOption = $question->options->firstWhere('id', $selectedOptionId);
                    $isCorrect = $selectedOption && $selectedOption->is_correct;

                    $attemptAnswer->is_correct = $isCorrect;

                    if ($isCorrect) {
                        $totalCorrect++;
                        $mark = $question->default_marks;
                        $attemptAnswer->marks_awarded = $mark;
                        $totalScore += $mark;
                        $question->recordAttempt(true);
                    } else {
                        $totalIncorrect++;
                        $negMark = $exam->negative_mark_per_question ?? $question->negative_marks;
                        $attemptAnswer->marks_awarded = -$negMark;
                        $totalNegativeMarks += $negMark;
                        $totalScore -= $negMark;
                        $question->recordAttempt(false);
                    }
                }

                $attemptAnswer->save();
            }

            $totalQuestions = max(1, $answers->count());
            $attemptedCount = $totalCorrect + $totalIncorrect;
            $accuracyPercentage = $attemptedCount > 0 ? ($totalCorrect / $attemptedCount) * 100 : 0;

            $attempt->status = 'completed';
            $attempt->completed_at = now();
            $attempt->total_score = max(0, $totalScore);
            $attempt->total_correct = $totalCorrect;
            $attempt->total_incorrect = $totalIncorrect;
            $attempt->total_unanswered = $totalUnanswered;
            $attempt->total_negative_marks = $totalNegativeMarks;
            $attempt->accuracy_percentage = round($accuracyPercentage, 2);
            $attempt->time_taken_seconds = $timeSpentSeconds;
            $attempt->tab_switch_count = $tabSwitches;
            $attempt->answers_state = $submittedAnswers;

            // Calculate Percentile
            $totalAttempts = ExamAttempt::where('exam_id', $exam->id)->where('status', 'completed')->count();
            if ($totalAttempts > 0) {
                $scoredLower = ExamAttempt::where('exam_id', $exam->id)
                    ->where('status', 'completed')
                    ->where('total_score', '<', $attempt->total_score)
                    ->count();
                $attempt->percentile_rank = round(($scoredLower / max(1, $totalAttempts)) * 100, 2);
            } else {
                $attempt->percentile_rank = 100.00;
            }

            $attempt->save();

            // Gamification: Update user streak & coins
            $user->updateStreak();
            $earnedCoins = max(10, (int)($attempt->total_score * 5));
            $user->increment('coins', $earnedCoins);

            // Award Badges
            $firstBadge = Badge::where('code', 'FIRST_EXAM')->first();
            if ($firstBadge && !$user->badges()->where('badge_id', $firstBadge->id)->exists()) {
                $user->badges()->attach($firstBadge->id, ['awarded_at' => now()]);
            }

            if ($attempt->accuracy_percentage >= 90.0 && $attemptedCount >= 5) {
                $sniperBadge = Badge::where('code', 'ACCURACY_SNIPER')->first();
                if ($sniperBadge && !$user->badges()->where('badge_id', $sniperBadge->id)->exists()) {
                    $user->badges()->attach($sniperBadge->id, ['awarded_at' => now()]);
                }
            }

            return $attempt;
        });
    }

    /**
     * Generate custom quiz on the fly.
     */
    public function generateCustomExam(User $user, array $filters): Exam
    {
        $query = Question::where('status', 'published');

        if (!empty($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }
        if (!empty($filters['topic_id'])) {
            $query->where('topic_id', $filters['topic_id']);
        }
        if (!empty($filters['setter_organization_id'])) {
            $query->where('setter_organization_id', $filters['setter_organization_id']);
        }
        if (!empty($filters['difficulty'])) {
            $query->where('difficulty', $filters['difficulty']);
        }

        $limit = min(50, max(5, (int)($filters['question_count'] ?? 10)));
        $questions = $query->inRandomOrder()->limit($limit)->get();

        $title = 'কাস্টম প্র্যাকটিস টেস্ট (' . date('d M, Y h:i A') . ')';

        return DB::transaction(function () use ($user, $questions, $title, $limit) {
            $exam = Exam::create([
                'title_bn' => $title,
                'title_en' => 'Custom Practice Test',
                'slug' => 'custom-' . Str::random(10),
                'exam_mode' => 'custom',
                'total_questions' => $questions->count(),
                'total_marks' => $questions->count(),
                'duration_minutes' => (int)ceil($questions->count() * 1.0), // 1 min per question
                'negative_mark_per_question' => 0.50,
                'is_published' => true,
                'allow_pause' => true,
                'shuffle_questions' => true,
                'shuffle_options' => true,
                'created_by' => $user->id,
            ]);

            foreach ($questions as $index => $q) {
                ExamQuestion::create([
                    'exam_id' => $exam->id,
                    'question_id' => $q->id,
                    'marks' => 1.00,
                    'negative_marks' => 0.50,
                    'order' => $index + 1,
                ]);
            }

            return $exam;
        });
    }
}
