<?php

namespace App\Http\Resources;

use App\Laraweather\Contracts\WeatherInterface;
use App\Laraweather\Facades\Laraweather;
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
            $city = self::convert(Laraweather::getByCity(name: $data['city']));

        }
        return WeatherResource::make($city);
    }

    private static function convert(WeatherInterface $weather): City
    {
        $city = new City();
        $city->name = $weather->getName();
        $city->country = $weather->getCountry();
        $lonLat = $weather->getLonLat();
        $city->lon = $lonLat[0];
        $city->lat = $lonLat[1];
        $city->save();
        $city->forecasts()->create(attributes: [
           'min' => $weather->getMin(),
           'max' => $weather->getMax(),
           'feels' => $weather->getFeels(),
           'description' => $weather->getDescription(),
        ]);
        return $city;
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
