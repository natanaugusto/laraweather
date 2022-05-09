<?php
use App\Laraweather\Client;

test(description: 'Instaciate Laraweather/Client', closure: function ($weatherReturn) {
    mockHttp(body: $weatherReturn);
    $laraweather = new Client();
    $this->assertInstanceOf(
        expected: \Illuminate\Http\Client\Response::class,
        actual: $laraweather->getByCity(name: 'Franco da Rocha')
    );
})->with(data: 'weatherapi/openweatherapi/weather');
