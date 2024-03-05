<?php

namespace App\Http\Resources\Tools\Bizig;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerBatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'section_id' => $this->section_id,
            'editing' => false,
            'answers' => $this->answers->map(function ($answer) {
                return [
                    'id' => $answer->id,
                    'input_id' => $answer->input_id,
                    'body' => $answer->body,
                ];
            }),
        ];
    }
}
