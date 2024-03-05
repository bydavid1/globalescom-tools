<?php

namespace App\Http\Resources\Tools\Bizig;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InputResource extends JsonResource
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
            'type' => $this->type->name,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'options' => json_decode($this->options),

        ];
    }
}
