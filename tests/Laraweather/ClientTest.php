<?php

use App\Laraweather\Client;
use App\Laraweather\Contracts\WeatherInterface;
use App\Laraweather\Facades\Weather as WeatherFacade;

test(description: 'Instaciate Laraweather/Client', closure: function ($weatherReturn) {
    mockHttp(body: $weatherReturn);
    $laraweather = new Client(
        driver: new \App\Laraweather\Drivers\TestDriver(),
        weather: new \App\Laraweather\Weather()
    );
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

test(description: 'Using Weather facade', closure: function ($weatherBody) {
    mockHttp($weatherBody);
    providers();

    $this->assertInstanceOf(
        expected: WeatherInterface::class,
        actual: WeatherFacade::getByCity(name: 'Franco da Rocha')
    );
})->with(data: 'weatherapi/openweatherapi/weather');;
