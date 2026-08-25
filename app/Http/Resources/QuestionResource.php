<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => [
                'id' => $this->subject_id,
                'name_bn' => $this->subject?->name_bn,
                'name_en' => $this->subject?->name_en,
                'color' => $this->subject?->color,
            ],
            'topic' => $this->topic ? [
                'id' => $this->topic_id,
                'name_bn' => $this->topic?->name_bn,
                'name_en' => $this->topic?->name_en,
            ] : null,
            'setter_organization' => $this->setterOrganization ? [
                'id' => $this->setter_organization_id,
                'name_bn' => $this->setterOrganization?->name_bn,
                'code' => $this->setterOrganization?->code,
            ] : null,
            'stem_bn' => $this->stem_bn,
            'stem_en' => $this->stem_en,
            'difficulty' => $this->difficulty,
            'default_marks' => (float)$this->default_marks,
            'negative_marks' => (float)$this->negative_marks,
            'explanation_bn' => $this->explanation_bn,
            'explanation_en' => $this->explanation_en,
            'reference_source' => $this->reference_source,
            'accuracy_rate' => (float)$this->accuracy_rate,
            'options' => $this->options->map(function ($opt) {
                return [
                    'id' => $opt->id,
                    'letter' => $opt->option_letter,
                    'text_bn' => $opt->option_text_bn,
                    'text_en' => $opt->option_text_en,
                    'is_correct' => $opt->is_correct,
                ];
            }),
            'tags' => $this->tags->pluck('tag_value'),
        ];
    }
}
