<?php
use Symfony\Component\HttpFoundation\Response as HttpResponse;

test(description: 'Http\WeatherController index', closure: function () {
    $this->get(route(name: 'weather.index'))
        ->assertStatus(status: HttpResponse::HTTP_OK);
});

test(description: 'Http\WeatherController store', closure: function () {
    $this->post(route(name: 'weather.store'))
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
