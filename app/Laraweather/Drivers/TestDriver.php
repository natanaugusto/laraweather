<?php

namespace App\Laraweather\Drivers;

use App\Laraweather\Contracts\WeatherInterface;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class TestDriver implements \App\Laraweather\Contracts\DriverInterface
{
    public function getBaseUrl(): string
    {
        return 'http://weaterapi';
    }

    public function getApiKey(): string
    {
        return 'API-KEY';
    }

    public function getFromAPI(mixed $q): Response
    {
        return Http::get(
            url: $this->getBaseUrl(),
            query: $q
        );
    }

    public function toQuery(WeatherInterface $query): array
    {
        return [
            'q' => $query->getName(),
            'appid' => $this->getApiKey()
        ];
    }

    public function toWeather(Response $response, WeatherInterface $weather = null): WeatherInterface
    {
        $body = json_decode(
            json: $response->body(),
            associative: true
        );
        $weather->setRaw(value: $body);
        $weather->setName(value: $body['name']);
        $weather->setCountry(value: $body['sys']['country']);
        $weather->setDescription(value: $body['weather'][0]['description']);
        $weather->setLonLat(lon: $body['coord']['lon'], lat: $body['coord']['lat']);
        $weather->setMin(value: $body['main']['temp_min']);
        $weather->setMax(value: $body['main']['temp_max']);
        $weather->setFeels(value: $body['main']['feels_like']);
        $weather->setLastUpdate(date: Carbon::parse($body['dt']));
        return $weather;
    }
}
