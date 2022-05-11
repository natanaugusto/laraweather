<?php

use App\Laraweather\Client;
use App\Laraweather\Facades\Laraweather;
use App\Laraweather\Contracts\WeatherInterface;
use App\Laraweather\Events\FetchedFromWeatherAPI;
use App\Laraweather\Listeners\LogWeatherFetched;

use Illuminate\Support\Facades\Event;

test(description: 'Instaciate Laraweather/Client', closure: function ($weatherReturn) {
    Event::fake();
    mockHttp(body: $weatherReturn);
    $laraweather = new Client(
        driver: new \App\Laraweather\Drivers\TestDriver(),
        weather: new \App\Laraweather\Weather()
    );
    $weather = $laraweather->getByCity(name: 'Franco da Rocha');
    Event::assertDispatched(event: function (FetchedFromWeatherAPI $event) use ($weather) {
        return $event->weather === $weather;
    });
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
            'feels' => 290.57,
            'last_update' => '2022-05-06 11:59:57',
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

test(description: 'Using Weather facade', closure: function ($weatherBody) {
    mockHttp($weatherBody);
    provider();
    Event::fake();
    Event::listen(events: FetchedFromWeatherAPI::class, listener: LogWeatherFetched::class);
    $weather = Laraweather::getByCity(name: 'Franco da Rocha');
    $this->assertInstanceOf(
        expected: WeatherInterface::class,
        actual: $weather
    );
    Event::assertDispatched(event: function (FetchedFromWeatherAPI $event) use ($weather) {
        return $event->weather === $weather;
    });
    Event::assertListening(
        expectedEvent: FetchedFromWeatherAPI::class,
        expectedListener: LogWeatherFetched::class
    );
})->with(data: 'weatherapi/openweatherapi/weather');
