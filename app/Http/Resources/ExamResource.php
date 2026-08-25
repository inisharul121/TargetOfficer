<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title_bn' => $this->title_bn,
            'title_en' => $this->title_en,
            'description_bn' => $this->description_bn,
            'exam_mode' => $this->exam_mode,
            'total_questions' => $this->total_questions,
            'total_marks' => (float)$this->total_marks,
            'duration_minutes' => $this->duration_minutes,
            'negative_mark_per_question' => (float)$this->negative_mark_per_question,
            'allow_pause' => $this->allow_pause,
            'organization' => $this->organization ? [
                'id' => $this->organization->id,
                'name_bn' => $this->organization->name_bn,
                'code' => $this->organization->code,
            ] : null,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
