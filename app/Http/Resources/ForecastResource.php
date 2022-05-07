<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ForecastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'min' => round(num: $this->min, precision: 2),
            'max' => round(num: $this->max, precision: 2),
            'feels' => round(num: $this->feels, precision: 2),
            'description' => $this->description,
        ];
    }
}
