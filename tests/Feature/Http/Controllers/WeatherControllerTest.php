<?php
use App\Models\City;
use App\Models\Forecast;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

uses(classAndTraits: \Illuminate\Foundation\Testing\RefreshDatabase::class);

test(description: 'Http\WeatherController index', closure: function () {
    $this->get(uri: route(name: 'weather.index'))
        ->assertStatus(status: HttpResponse::HTTP_NO_CONTENT);

    $weather = array_map(
        callback: function ($city) {
            $forecasts = array_map(
                callback: fn ($forecast) => Arr::only(
                    array: $forecast,
                    keys: ['description', 'min', 'max', 'feels']
                ),
                array: Forecast::factory(count: 5)
                    ->create(attributes: ['city_id' => $city['id']])
                    ->toArray()
            );
            return array_merge(
                Arr::only(array: $city, keys: ['name', 'country', 'lon', 'lat']),
                ['forecasts' => $forecasts]
            );
        },
        array: City::factory(count: 5)->create()->toArray(),

    );
    $this->assertIsArray(actual: $weather);
    $this->get(uri: route(name: 'weather.index'))
        ->assertStatus(status: HttpResponse::HTTP_OK)
        ->assertJson(value: $weather);

});

$cityName = 'Franco da Rocha';
test(description: 'Http\WeatherController fetch/delete', closure: function ($weatherBody) use ($cityName) {
    mockHttp(body: $weatherBody);
    providers();

    $this->get(uri: route(name: 'weather.fetch', parameters: ['city' => $cityName]))
        ->assertStatus(status: HttpResponse::HTTP_CREATED);
    $this->assertDatabaseHas(table: City::class, data: ['name' => $cityName]);

    $this->delete(uri: route(name: 'weather.destroy', parameters: ['city' => $cityName]))
        ->assertStatus(status: HttpResponse::HTTP_ACCEPTED);
    $this->assertSoftDeleted(table: City::class, data: ['name' => $cityName]);
})->with(data: 'weatherapi/openweatherapi/weather');
