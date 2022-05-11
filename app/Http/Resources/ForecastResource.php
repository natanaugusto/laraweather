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
            'min' => number_format(num: $this->min, decimals: 2),
            'max' => number_format(num: $this->max, decimals: 2),
            'feels' => number_format(num: $this->feels, decimals: 2),
            'description' => $this->description,
            'last_update' => $this->last_update,
        ];
    }
}
