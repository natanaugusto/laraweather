<?php
use App\Laraweather\Client;
use Illuminate\Support\Facades\Http;

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

    public function getFromAPI(mixed $q): \Illuminate\Http\Client\Response
    {
        return Http::get(
            url: $this->getBaseUrl(),
            query: $q
        );
    }
};

test(description: 'Instaciate Laraweather/Client', closure: function ($weatherReturn) use ($driver) {
    mockHttp(body: $weatherReturn);
    $laraweather = new Client(driver: $driver);
    $this->assertInstanceOf(
        expected: \Illuminate\Http\Client\Response::class,
        actual: $laraweather->getByCity(name: 'Franco da Rocha')
    );
})->with(data: 'weatherapi/openweatherapi/weather');
