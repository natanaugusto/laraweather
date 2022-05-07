<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
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
            'name' => $this->name,
            'country' => $this->country,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'forecasts' => ForecastResource::collection($this->forecasts),
        ];
    }
}
