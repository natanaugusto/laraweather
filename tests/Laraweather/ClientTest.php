<?php

use App\Laraweather\Client;
use App\Laraweather\Contracts\WeatherInterface;
use Illuminate\Http\Client\Response as HttpClientResponse;
use Illuminate\Support\Facades\Http;

$weather = new \App\Laraweather\Weather();

$driver = new class implements \App\Laraweather\Contracts\DriverInterface
{
    public function getBaseUrl(): string
    {
        return 'http://weaterapi';
    }

    public function getApiKey(): string
    {
        return 'API-KEY';
    }

    public function getFromAPI(mixed $q): HttpClientResponse
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

    public function toWeather(HttpClientResponse $response, WeatherInterface $weather = null): WeatherInterface
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
        return $weather;
    }
};

test(description: 'Instaciate Laraweather/Client', closure: function ($weatherReturn) use ($driver, $weather) {
    mockHttp(body: $weatherReturn);
    $laraweather = new Client(driver: $driver, weather: $weather);
    $weather = $laraweather->getByCity(name: 'Franco da Rocha');
    $this->assertInstanceOf(
        expected: WeatherInterface::class,
        actual: $weather
    );
    $this->assertEquals(
        expected: [
            'name' => 'Franco da Rocha',
            'country' => 'BR',
            'description' => 'scattered clouds',
            'lon' => -46.7269,
            'lat' => -23.3217,
            'min' => 288.48,
            'max' => 292.63,
            'feels' => 290.57
        ],
        actual: $weather->getArgs()
    );

    $meta = stream_get_meta_data(stream: $weatherReturn);
    $this->assertEquals(
        expected: json_decode(
            json: file_get_contents(filename: $meta['uri']),
            associative: true
        ),
        actual: $weather->getRaw()
    );
})->with(data: 'weatherapi/openweatherapi/weather');
