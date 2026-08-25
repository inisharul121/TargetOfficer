<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamAttemptResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'exam_title' => $this->exam?->title_bn,
            'status' => $this->status,
            'total_score' => (float)$this->total_score,
            'total_correct' => $this->total_correct,
            'total_incorrect' => $this->total_incorrect,
            'total_unanswered' => $this->total_unanswered,
            'total_negative_marks' => (float)$this->total_negative_marks,
            'accuracy_percentage' => (float)$this->accuracy_percentage,
            'percentile_rank' => (float)$this->percentile_rank,
            'time_taken_seconds' => $this->time_taken_seconds,
            'started_at' => $this->started_at?->toIso8601String(),
            'completed_at' => $this->completed_at?->toIso8601String(),
        ];
    }
}
