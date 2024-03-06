<?php

namespace App\Http\Resources\Tools\Bizig;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerspectiveResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'data' => json_decode($this->data),
            'children' => $this->children->map(function ($child) {
                return [
                    'id' => $child->id,
                    'name' => $child->name,
                    'type' => $child->sectionType->name,

                ];
            }),
            'form' => FormResource::make($this->children->first()->forms->first()),
            'answers_batches' => AnswerBatchResource::collection($this->children->flatMap(function ($child) {
                return $child->answerBatches;
            }))

        ];
    }
}
