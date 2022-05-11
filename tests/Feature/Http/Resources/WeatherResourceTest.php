<?php
use App\Models\City;
use App\Http\Resources\WeatherResource;

uses(classAndTraits: \Illuminate\Foundation\Testing\RefreshDatabase::class);

test(description: 'WeatherResource::fetch', closure: function ($weatherBody) {
    mockHttp(body: $weatherBody);
    provider();
    $cityName = 'Franco da Rocha';

    $this->assertDatabaseMissing(table: City::class, data: ['name' => $cityName]);
    $weather = WeatherResource::fetch(data: ['city' => $cityName]);
    $this->assertInstanceOf(expected: WeatherResource::class, actual: $weather);
    $this->assertDatabaseHas(table: City::class, data: ['name' => $cityName]);

    WeatherResource::fetch(data: ['city' => $cityName]);
    $this->assertDatabaseCount(table: City::class, count: 1);
    WeatherResource::fetch(data: ['city' => $cityName]);
})->with(data: 'weatherapi/openweatherapi/weather');;
