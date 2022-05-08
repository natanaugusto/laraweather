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

test(description: 'Http\WeatherController store', closure: function () {
    $this->post(uri: route(name: 'weather.store'))
        ->assertStatus(status: HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
    $cityName = 'Franco da Rocha';
    $this->post(uri: route(name: 'weather.store'), data: ['city' => $cityName])
        ->assertJsonFragment(data: ['name' => $cityName])
        ->assertStatus(status: HttpResponse::HTTP_CREATED);
});

test(description: 'Http\WeatherController show', closure: function () {
    $this->get(route(name: 'weather.show', parameters: ['weather' => 1]))
        ->assertStatus(status: HttpResponse::HTTP_OK);
});

test(description: 'Http\WeatherController update', closure: function () {
    $this->put(route(name: 'weather.update', parameters: ['weather' => 1]))
        ->assertStatus(status: HttpResponse::HTTP_ACCEPTED);
});

test(description: 'Http\WeatherController destroy', closure: function () {
    $this->delete(route(name: 'weather.destroy', parameters: ['weather' => 1]))
        ->assertStatus(status: HttpResponse::HTTP_ACCEPTED);
});
