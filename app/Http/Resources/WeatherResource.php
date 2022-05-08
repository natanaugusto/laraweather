<?php

namespace App\Http\Resources;

use App\Models\City;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * I don't know if this logica can be put here. But, seems to
     * me a Good Class to deal with all things for WeatherResources.
     *
     * Maybe I'm breaking the Single Responsabilite pattern.
     *
     * @param array $data
     * @return static
     */
    public static function fetch(array $data): self
    {
        $city = City::where(column: 'name', value: $data['city'])->first();
        if (is_null($city)) {
            $city = City::factory()->create(attributes: ['name' => $data['city']]);
        }
        return WeatherResource::make($city);
    }

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
